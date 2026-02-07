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

        // sprawdź czy kategoria istnieje
        $categoryName = $service->getCategoryName($category);
        if ($categoryName === $category) {
            // nie znaleziono kategorii w mapie
            http_response_code(404);
            require __DIR__ . '/../views/404.view.php';
            return;
        }

        $products = $service->getProductsByCategory($category);

        require __DIR__ . '/../views/catalog-category.view.php';
    }
}
