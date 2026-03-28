<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryAdminService
{
    // Używamy Dependency Injection zamiast tworzyć połączenie wewnątrz
    public function __construct(private CategoryRepository $repo) {}

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
        // Jeśli slug jest pusty, generujemy go z nazwy
        if (empty($data['slug'])) {
            $data['slug'] = $this->generateSlug($data['name']);
        }

        return $this->repo->create($data);
    }

    private function wouldCreateCycle(int $categoryId, ?int $newParentId): bool
    {
        if ($newParentId === null) {
            return false;
        }

        if ($newParentId === $categoryId) {
            return true;
        }

        $current = $newParentId;

        while ($current !== null) {
            if ($current === $categoryId) {
                return true;
            }

            $parent = $this->repo->find($current);
            if (!$parent) {
                break;
            }

            $current = $parent->parent_id;
        }

        return false;
    }

    public function update(int $id, array $data)
    {
        $category = $this->repo->find($id);
        if (!$category) {
            throw new \Exception("Kategoria nie istnieje.");
        }

        $newParent = $data['parent_id'] === '' ? null : (int)$data['parent_id'];
        if ($this->wouldCreateCycle($id, $newParent)) {
            throw new \Exception("Nie można ustawić kategorii jako rodzica własnego potomka.");
        }

        $slug = empty($data['slug']) ? $this->generateSlug($data['name']) : $data['slug'];

        $payload = [
            'draft_name' => $data['name'],
            'draft_slug' => $slug,
            'draft_description' => $data['description'] ?? null,
            'draft_image_path' => $data['draft_image_path'] ?: $category->draft_image_path,
            'draft_parent_id' => $newParent,
            'has_draft' => 1,
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
        if (!$category || !$category->has_draft) {
            throw new \Exception("Brak wersji roboczej do opublikowania.");
        }

        $payload = [
            'name' => $category->draft_name,
            'slug' => $category->draft_slug,
            'description' => $category->draft_description,
            'image_path' => $category->draft_image_path,
            'parent_id' => $category->draft_parent_id,
        ];

        return $this->repo->publish($id, $payload);
    }

    public function delete(int $id)
    {
        $category = $this->repo->find($id);

        if ($category) {
            // Usuwamy główny obrazek, jeśli istnieje
            if ($category->image_path) {
                $path = ROOT_PATH . '/' . $category->image_path;
                if (is_file($path)) unlink($path);
            }
            // Usuwamy również obrazek z draftu (aby nie powstał wyciek plików na dysku)
            if ($category->draft_image_path && $category->draft_image_path !== $category->image_path) {
                $draftPath = ROOT_PATH . '/' . $category->draft_image_path;
                if (is_file($draftPath)) unlink($draftPath);
            }
        }

        return $this->repo->delete($id);
    }

    // Prosty helper do generowania sluga
    private function generateSlug(string $text): string
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        return strtolower($text);
    }
}
