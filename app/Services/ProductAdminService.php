<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Repositories\ProductImageRepository;
use App\Models\Product;

class ProductAdminService
{
    public function __construct(
        private ProductRepository $products,
        private ProductImageRepository $images
    ) {}

    private function slugify(string $text): string
    {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^a-z0-9]+/u', '-', $text);
        return trim($text, '-');
    }

    public function createProduct(array $data): Product
    {
        $slug = $this->slugify($data['name']);

        // upewniamy się, że slug jest unikalny
        $original = $slug;
        $i = 2;

        while ($this->products->findBySlug($slug)) {
            $slug = $original . '-' . $i;
            $i++;
        }

        $data['slug'] = $slug;

        $id = $this->products->create($data);

        return $this->products->find($id);
    }

    public function updateProduct(int $id, array $data): void
    {
        $product = $this->products->find($id);
        if (!$product) {
            throw new \Exception('Produkt nie istnieje');
        }

        $this->products->update($id, $data);
    }

    /**
     * Produkty w danej kategorii (do listy w panelu).
     *
     * @return Product[]
     */
    public function getByCategory(int $categoryId): array
    {
        return $this->products->findByCategory($categoryId);
    }

    public function find(int $id): ?Product
    {
        return $this->products->find($id);
    }

    public function delete(int $id): void
    {
        $product = $this->products->find($id);
        if (!$product) {
            return;
        }

        // 1. Pobierz obrazki
        $images = $this->images->findByProduct($product->id);

        // 2. Usuń pliki z dysku
        $year  = date('Y', strtotime($product->created_at ?? 'now'));
        $month = date('m', strtotime($product->created_at ?? 'now'));
        $slug  = $product->slug;

        $dir = ROOT_PATH . "/uploads/products/$year/$month/$slug";

        if (is_dir($dir)) {
            $files = glob("$dir/*");
            foreach ($files as $f) {
                @unlink($f);
            }
            @rmdir($dir);
        }


        // 3. Usuń rekordy obrazków (FK ma ON DELETE CASCADE, ale czyścimy jawnie)
        $this->images->deleteByProduct($product->id);

        // 4. Usuń produkt
        $this->products->delete($product->id);
    }

    public function uploadImage(int $productId, array $file): string
    {
        $product = $this->products->find($productId);
        if (!$product) {
            throw new \Exception("Produkt nie istnieje");
        }

        $slug = $product->slug;

        // limit 5 zdjęć
        $existing = $this->images->findByProduct($productId);
        if (count($existing) >= 5) {
            throw new \Exception("Limit 5 zdjęć został osiągnięty");
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($ext, $allowed)) {
            throw new \Exception("Niedozwolony format pliku");
        }

        $year  = date('Y');
        $month = date('m');

        $dir = "uploads/products/$year/$month/$slug";
        $fullDir = ROOT_PATH . "/$dir";

        if (!is_dir($fullDir)) {
            mkdir($fullDir, 0777, true);
        }

        // wybieramy numer zdjęcia 1–5
        $numbers = array_map(fn($img) => (int)preg_replace('/\D/', '', pathinfo($img->path, PATHINFO_FILENAME)), $existing);
        $next = 1;

        while (in_array($next, $numbers)) {
            $next++;
        }

        if ($next > 5) {
            throw new \Exception("Limit 5 zdjęć został osiągnięty");
        }

        $filename = "{$slug}{$next}.{$ext}";
        $path = "$dir/$filename";
        $fullPath = ROOT_PATH . "/$path";

        // nadpisywanie
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        if (!move_uploaded_file($file['tmp_name'], $fullPath)) {
            throw new \Exception("Nie udało się zapisać pliku");
        }

        // zapis do bazy
        $this->images->create($productId, [
            'path' => $path,
            'is_main' => 0,
            'sort_order' => $next
        ]);

        return $path;
    }

    public function deleteImage(int $productId, int $imageId): void
    {
        $img = $this->images->find($imageId);
        if (!$img || $img->product_id != $productId) {
            return;
        }

        $full = ROOT_PATH . "/" . $img->path;
        if (is_file($full)) {
            unlink($full);
        }

        $this->images->delete($imageId);
    }

    public function setMainImage(int $productId, int $imageId): void
    {
        $this->images->unsetMainForProduct($productId);
        $this->images->setMain($imageId);
    }
    // CRUD (create/update) dopełnimy w kolejnych krokach

    public function moveTempImagesToProduct(int $productId, string $slug): void
    {
        $sessionId = session_id();
        $tmpDir = ROOT_PATH . "/uploads/tmp/products/$sessionId";

        if (!is_dir($tmpDir)) {
            return;
        }

        $year = date('Y');
        $month = date('m');

        $finalDir = ROOT_PATH . "/uploads/products/$year/$month/$slug";

        if (!is_dir($finalDir)) {
            mkdir($finalDir, 0777, true);
        }

        $files = glob("$tmpDir/*");

        $counter = 1;

        foreach ($files as $file) {
            if ($counter > 5) break;

            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $newName = "{$slug}{$counter}.{$ext}";
            $newPath = "$finalDir/$newName";

            rename($file, $newPath);

            $this->images->create($productId, [
                'path' => "uploads/products/$year/$month/$slug/$newName",
                'is_main' => $counter === 1 ? 1 : 0,
                'sort_order' => $counter
            ]);

            $counter++;
        }

        // usuń katalog tymczasowy
        rmdir($tmpDir);
    }
}
