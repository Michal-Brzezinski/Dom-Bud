<?php

namespace App\Repositories;

use PDO;
use App\Models\ProductImage;

class ProductImageRepository
{
    public function __construct(private PDO $pdo) {}

    /**
     * Zwraca wszystkie obrazki danego produktu.
     *
     * @return ProductImage[]
     */
    public function findByProduct(int $productId): array
    {
        $stmt = $this->pdo->prepare('
            SELECT * FROM product_images
            WHERE product_id = :product_id
            ORDER BY is_main DESC, sort_order ASC, id ASC
        ');
        $stmt->execute(['product_id' => $productId]);

        $rows = $stmt->fetchAll();

        return array_map(fn($row) => new ProductImage($row), $rows);
    }

    public function find(int $id): ?ProductImage
    {
        $stmt = $this->pdo->prepare('SELECT * FROM product_images WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ? new ProductImage($row) : null;
    }

    public function deleteByProduct(int $productId): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM product_images WHERE product_id = :product_id');
        $stmt->execute(['product_id' => $productId]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM product_images WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function create(int $productId, array $data): int
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO product_images (product_id, path, alt, is_main, sort_order)
            VALUES (:product_id, :path, :alt, :is_main, :sort_order)
        ');

        $stmt->execute([
            'product_id' => $productId,
            'path'       => $data['path'],
            'alt'        => $data['alt'] ?? null,
            'is_main'    => !empty($data['is_main']) ? 1 : 0,
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function unsetMainForProduct(int $productId): void
    {
        $stmt = $this->pdo->prepare('
            UPDATE product_images
            SET is_main = 0
            WHERE product_id = :product_id
        ');
        $stmt->execute(['product_id' => $productId]);
    }

    public function setMain(int $imageId): void
    {
        $stmt = $this->pdo->prepare('
            UPDATE product_images
            SET is_main = 1
            WHERE id = :id
        ');
        $stmt->execute(['id' => $imageId]);
    }
}
