<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Services\ProductAdminService;

class CategoryAdminService
{
    public function __construct(
        private CategoryRepository $repo,
        private ?ProductAdminService $productService = null
    ) {}

    public function all()
    {
        return $this->repo->getAll();
    }

    public function find(int $id)
    {
        return $this->repo->find($id);
    }

    public function findPublished(int $id)
    {
        return $this->repo->findPublished($id);
    }

    public function findBySlug(string $slug)
    {
        return $this->repo->findBySlug($slug);
    }

    public function create(array $data)
    {
        if (empty($data['slug'])) {
            $data['slug'] = $this->generateSlug($data['name']);
        }

        return $this->repo->create($data);
    }

    // =========================
    // Drzewo kategorii do widoku
    // =========================

    /**
     * Zwraca spłaszczone drzewo kategorii z informacją o poziomie zagnieżdżenia.
     *
     * Każdy element:
     * [
     *   'cat'            => Category,
     *   'depth'          => int,
     *   'children_count' => int
     * ]
     */
    public function getTreeFlat(): array
    {
        $all = $this->repo->getAll(); // zwraca tablicę Category
        $tree = $this->buildTree($all);

        $flat = [];
        $this->flattenTree($tree, 0, $flat);

        return $flat;
    }

    /**
     * Buduje drzewo z płaskiej listy Category.
     *
     * Zwraca tablicę węzłów:
     * [
     *   [
     *     'cat'      => Category,
     *     'children' => [ ... ]
     *   ],
     *   ...
     * ]
     */
    private function buildTree(array $categories, ?int $parentId = null): array
    {
        $branch = [];

        foreach ($categories as $cat) {
            $catParentId = $cat->parent_id !== null ? (int)$cat->parent_id : null;

            if ($catParentId === $parentId) {
                $branch[] = [
                    'cat'      => $cat,
                    'children' => $this->buildTree($categories, (int)$cat->id),
                ];
            }
        }

        return $branch;
    }

    /**
     * Spłaszcza drzewo do listy z poziomem zagnieżdżenia.
     */
    private function flattenTree(array $nodes, int $depth, array &$flat): void
    {
        foreach ($nodes as $node) {
            $cat      = $node['cat'];
            $children = $node['children'] ?? [];
            $flat[] = [
                'cat'            => $cat,
                'depth'          => $depth,
                'children_count' => count($children),
            ];

            if (!empty($children)) {
                $this->flattenTree($children, $depth + 1, $flat);
            }
        }
    }

    // =========================
    // Helpers
    // =========================

    private function wouldCreateCycle(int $categoryId, ?int $newParentId): bool
    {
        while ($newParentId !== null) {
            if ($newParentId === $categoryId) {
                return true;
            }

            $parent = $this->repo->find($newParentId);
            $newParentId = $parent?->parent_id;
        }

        return false;
    }

    private function deleteCategoryImages($category): void
    {
        if (!$category) return;

        if ($category->image_path) {
            $path = ROOT_PATH . '/' . ltrim($category->image_path, '/');
            if (is_file($path)) unlink($path);
        }

        if ($category->draft_image_path && $category->draft_image_path !== $category->image_path) {
            $draftPath = ROOT_PATH . '/' . ltrim($category->draft_image_path, '/');
            if (is_file($draftPath)) unlink($draftPath);
        }
    }

    public function update(int $id, array $data)
    {
        $category = $this->repo->find($id);
        if (!$category) {
            throw new \Exception("Kategoria nie istnieje.");
        }

        $newParent = $data['parent_id'] === '' ? null : (int)$data['parent_id'];
        if ($this->wouldCreateCycle($id, $newParent)) {
            throw new \Exception("Nie można ustawić kategorii podrzędnej jako swojej kategorii nadrzędnej.");
        }

        $slug = empty($data['slug']) ? $this->generateSlug($data['name']) : $data['slug'];

        $payload = [
            'draft_name'        => $data['name'],
            'draft_slug'        => $slug,
            'draft_description' => $data['description'] ?? null,
            'draft_image_path'  => $data['draft_image_path'] ?: $category->draft_image_path,
            'draft_parent_id'   => $newParent,
            'has_draft'         => 1,
        ];

        return $this->repo->updateDraft($id, $payload);
    }

    public function forceUpdate(int $id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function publish(int $id)
    {
        $category = $this->repo->find($id);
        if (!$category) {
            throw new \Exception("Kategoria nie istnieje.");
        }

        // Jeśli nie ma draftu → utwórz go automatycznie
        if (!$category->has_draft) {
            $payload = [
                'draft_name'        => $category->name,
                'draft_slug'        => $category->slug,
                'draft_description' => $category->description,
                'draft_image_path'  => $category->image_path,
                'draft_parent_id'   => $category->parent_id,
                'has_draft'         => 1,
            ];

            $this->repo->updateDraft($id, $payload);

            // Pobierz ponownie zaktualizowaną kategorię
            $category = $this->repo->find($id);
        }

        // Teraz publikacja działa zawsze
        $payload = [
            'name'        => $category->draft_name,
            'slug'        => $category->draft_slug,
            'description' => $category->draft_description,
            'image_path'  => $category->draft_image_path,
            'parent_id'   => $category->draft_parent_id,
        ];

        return $this->repo->publish($id, $payload);
    }


    public function delete(int $id)
    {
        $category = $this->repo->find($id);

        if ($category) {
            if ($category->image_path) {
                $path = ROOT_PATH . '/' . $category->image_path;
                if (is_file($path)) unlink($path);
            }

            if ($category->draft_image_path && $category->draft_image_path !== $category->image_path) {
                $draftPath = ROOT_PATH . '/' . $category->draft_image_path;
                if (is_file($draftPath)) unlink($draftPath);
            }
        }

        return $this->repo->delete($id);
    }

    public function deleteRecursive(int $id): void
    {
        $category = $this->repo->find($id);
        if (!$category) return;

        $children = $this->repo->findChildren($category->id);
        foreach ($children as $child) {
            $this->deleteRecursive($child->id);
        }

        if ($this->productService) {
            $products = $this->productService->getByCategory($category->id);
            foreach ($products as $product) {
                $this->productService->delete($product->id);
            }
        }

        $this->deleteCategoryImages($category);
        $this->repo->delete($category->id);
    }

    private function generateSlug(string $text): string
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        return strtolower($text);
    }

    public function uploadCategoryImage(array $file, string $slug, ?string $currentPath = null): string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception('Błąd przesyłania pliku');
        }

        $info = @getimagesize($file['tmp_name']);
        if (!$info) {
            throw new \Exception('Plik nie jest obrazem lub format nieobsługiwany');
        }
        $mimeType = $info['mime'];

        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($mimeType, $allowedMimes)) {
            throw new \Exception('Nieprawidłowy format pliku');
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            throw new \Exception('Plik jest za duży (max 2MB)');
        }

        if ($currentPath) {
            $old = ROOT_PATH . '/' . ltrim($currentPath, '/');
            if (strpos(realpath($old), realpath(ROOT_PATH . '/uploads/categories')) === 0 && is_file($old)) {
                @unlink($old);
            }
        }

        $safeSlug = preg_replace('/[^a-z0-9-]/', '-', strtolower($slug));
        $safeSlug = trim($safeSlug, '-') ?: 'kategoria';

        $year  = date('Y');
        $month = date('m');

        $dir = ROOT_PATH . "/uploads/categories/$year/$month/";
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            switch ($mimeType) {
                case 'image/jpeg':
                    $ext = 'jpg';
                    break;
                case 'image/png':
                    $ext = 'png';
                    break;
                case 'image/webp':
                    $ext = 'webp';
                    break;
                default:
                    $ext = 'jpg';
            }
        }

        $hash     = substr(md5(uniqid('', true)), 0, 8);
        $filename = "{$safeSlug}_{$hash}.{$ext}";
        $path     = $dir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $path)) {
            throw new \Exception('Błąd zapisu pliku');
        }

        return "uploads/categories/$year/$month/$filename";
    }
}
