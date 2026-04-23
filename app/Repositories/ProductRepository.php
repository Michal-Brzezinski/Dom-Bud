<?php

namespace App\Repositories;

use PDO;
use App\Models\Product;
use App\Models\ProductImage;

class ProductRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare('
        INSERT INTO products (category_id, name, slug, price, description, properties)
        VALUES (:category_id, :name, :slug, :price, :description, :properties)
    ');

        $stmt->execute([
            'category_id' => $data['category_id'],
            'name'        => $data['name'],
            'slug'        => $data['slug'], // ← DODANE!
            'price'       => $data['price'],
            'description' => $data['description'] ?? null,
            'properties'  => !empty($data['properties'])
                ? json_encode($data['properties'], JSON_UNESCAPED_UNICODE)
                : null,
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->pdo->prepare('
        UPDATE products
        SET name = :name,
            price = :price,
            description = :description,
            properties = :properties
        WHERE id = :id
    ');

        $stmt->execute([
            'id'          => $id,
            'name'        => $data['name'],
            'price'       => $data['price'],
            'description' => $data['description'] ?? null,
            'properties'  => !empty($data['properties'])
                ? json_encode($data['properties'], JSON_UNESCAPED_UNICODE)
                : null,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM products WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM products ORDER BY name ASC');
        $rows = $stmt->fetchAll();
        return array_map(fn($row) => new Product($row), $rows);
    }

    public function getProductsByCategoryId(int $categoryId, string $query, string $sort): array
    {
        $sql = 'SELECT p.*, c.slug AS category_slug
                FROM products p
                LEFT JOIN categories c ON c.id = p.category_id
                WHERE p.category_id = :id
                ';
        $params = [':id' => $categoryId];

        if ($query !== '') {
            $sql .= ' AND LOWER(name) LIKE :q';
            $params[':q'] = '%' . strtolower($query) . '%';
        }

        $sql .= $sort === 'za' ? ' ORDER BY name DESC' : ' ORDER BY name ASC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        $rows = $stmt->fetchAll();

        if (!$rows) {
            return [];
        }

        $products = [];
        foreach ($rows as $row) {
            $products[$row['id']] = new Product($row);
        }

        $ids = array_keys($products);
        if (empty($ids)) {
            return [];
        }

        $in = implode(',', array_fill(0, count($ids), '?'));

        $stmt = $this->pdo->prepare(
            "SELECT * FROM product_images WHERE product_id IN ($in) ORDER BY is_main DESC, sort_order ASC"
        );
        $stmt->execute($ids);

        $images = $stmt->fetchAll();

        foreach ($images as $imgRow) {
            $image = new ProductImage($imgRow);
            $products[$imgRow['product_id']]->addImage($image);
        }

        return array_values($products);
    }


    // =========================
    // Dodatkowe metody dla panelu admina
    // =========================
    public function find(int $id): ?Product
    {
        $stmt = $this->pdo->prepare('
        SELECT p.*, c.slug AS category_slug
        FROM products p
        LEFT JOIN categories c ON c.id = p.category_id
        WHERE p.id = :id
    ');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        $product = new Product($row);

        // Pobierz zdjęcia produktu
        $stmt = $this->pdo->prepare('
        SELECT * FROM product_images
        WHERE product_id = :id
        ORDER BY is_main DESC, sort_order ASC, id ASC
    ');
        $stmt->execute(['id' => $id]);

        $images = $stmt->fetchAll();
        foreach ($images as $imgRow) {
            $product->addImage(new ProductImage($imgRow));
        }

        return $product;
    }

    /**
     * Produkty po kategorii (bez obrazków – do panelu admina).
     *
     * @return Product[]
     */
    public function findByCategory(int $categoryId): array
    {
        $stmt = $this->pdo->prepare('
            SELECT 
                p.*,
                (
                    SELECT path 
                    FROM product_images 
                    WHERE product_id = p.id AND is_main = 1 
                    LIMIT 1
                ) AS main_image_path
            FROM products p
            WHERE p.category_id = :category_id
            ORDER BY p.id DESC
        ');

        $stmt->execute(['category_id' => $categoryId]);

        $rows = $stmt->fetchAll();

        return array_map(fn($row) => new Product($row), $rows);
    }

    public function findBySlug(string $slug): ?Product
    {
        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE slug = :slug');
        $stmt->execute(['slug' => $slug]);
        $row = $stmt->fetch();

        return $row ? new Product($row) : null;
    }

    public function getImages(int $productId): array
    {
        $stmt = $this->pdo->prepare("
        SELECT * FROM product_images 
        WHERE product_id = ? 
        ORDER BY is_main DESC, sort_order ASC
    ");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(\PDO::FETCH_CLASS, \App\Models\ProductImage::class);
    }
}
