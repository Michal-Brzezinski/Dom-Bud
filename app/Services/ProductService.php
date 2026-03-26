<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Core\Database;

class ProductService
{
    private ProductRepository $repo;

    public function __construct()
    {
        $config = require __DIR__ . '/../Config/config.php';
        $pdo = Database::getConnection($config['db']);
        $this->repo = new ProductRepository($pdo);
    }

    public function getFilteredProductsByCategoryId(int $categoryId, string $q, string $sort): array
    {
        return $this->repo->getProductsByCategoryId($categoryId, $q, $sort);
    }
}
