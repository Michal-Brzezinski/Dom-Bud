<?php

namespace App\Controllers;

use App\Services\ProductService;
use App\Services\CategoryService;

class CatalogController
{
    public function index(): void
    {
        $categoryService = new CategoryService();
        $categories = $categoryService->getRootCategories();

        $category = null;

        require __DIR__ . '/../Views/catalog-categories.view.php';
    }

    public function category(string $slug): void
    {
        $categoryService = new CategoryService();
        $productService  = new ProductService();

        $category = $categoryService->findBySlug($slug);

        if (!$category) {
            http_response_code(404);
            require __DIR__ . '/../Views/404.view.php';
            return;
        }

        $children   = $categoryService->getChildren($category->id);
        $breadcrumb = $categoryService->getBreadcrumb($category->id);

        if (!empty($children)) {
            $categories = $children;
            require __DIR__ . '/../Views/catalog-categories.view.php';
            return;
        }

        $page = max(1, (int)($_GET['page'] ?? 1));
        $sort = $_GET['sort'] ?? 'az';
        $q    = trim($_GET['q'] ?? '');

        $perPage = 20;

        $allProducts = $productService->getFilteredProductsByCategoryId($category->id, $q, $sort);

        $total = count($allProducts);
        $totalPages = max(1, (int)ceil($total / $perPage));

        $products = array_slice($allProducts, ($page - 1) * $perPage, $perPage);

        // przekaż do widoku: $category, $breadcrumb, $products, $page, $totalPages, $sort, $q
        require __DIR__ . '/../Views/catalog-category.view.php';
    }
}
