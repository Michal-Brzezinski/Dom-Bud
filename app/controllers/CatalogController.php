<?php

namespace App\Controllers;

use App\Services\ProductService;

class CatalogController
{
    public function index(): void
    {
        require __DIR__ . '/../views/catalog-categories.view.php';
    }

    public function category(string $category): void
    {
        $service = new ProductService();

        $categoryName = $service->getCategoryName($category);
        if ($categoryName === $category) {
            http_response_code(404);
            require __DIR__ . '/../views/404.view.php';
            return;
        }

        // parametry GET
        $page = max(1, (int)($_GET['page'] ?? 1));
        $sort = $_GET['sort'] ?? 'az';
        $q    = trim($_GET['q'] ?? '');

        $perPage = 20;

        // pobierz przefiltrowane produkty
        $allProducts = $service->getFilteredProducts($category, $q, $sort);

        $total = count($allProducts);
        $totalPages = max(1, (int)ceil($total / $perPage));

        // paginacja
        $products = array_slice($allProducts, ($page - 1) * $perPage, $perPage);

        require __DIR__ . '/../views/catalog-category.view.php';
    }
}
