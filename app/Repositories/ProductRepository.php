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

    public function getProductsByCategory(string $category, string $query, string $sort): array
    {
        // 1. Pobierz produkty
        $sql = 'SELECT * FROM products WHERE category = :category';
        $params = [':category' => $category];

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

        // Zamień na modele
        $products = [];
        foreach ($rows as $row) {
            $products[$row['id']] = new Product($row);
        }

        // 2. Pobierz zdjęcia
        $ids = array_keys($products);
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
}
