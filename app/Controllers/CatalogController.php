<?php

namespace App\Controllers;

use App\Services\ProductService;
use App\Services\CategoryService;

class CatalogController
{
    public function index(): void
    {
        $categoryService = new CategoryService();
        $categories = $categoryService->getPublishedRootCategories();


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

        $children = $categoryService->getPublishedChildren($category->id);
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

    public function product(string $categorySlug, string $productSlug): void
    {
        $categoryService = new CategoryService();
        $productService  = new ProductService();

        // Pobierz kategorię
        $category = $categoryService->findBySlug($categorySlug);
        if (!$category) {
            http_response_code(404);
            require __DIR__ . '/../Views/404.view.php';
            return;
        }

        // Pobierz produkt
        $product = $productService->findBySlug($productSlug);
        if (!$product || $product->category_id !== $category->id) {
            http_response_code(404);
            require __DIR__ . '/../Views/404.view.php';
            return;
        }

        // Pobierz breadcrumb
        $breadcrumb = $categoryService->getBreadcrumb($category->id);

        // Pobierz zdjęcia
        $images = $productService->getImages($product->id);

        // Dekoduj properties JSON
        $properties = $product->properties ?? [];

        $breadcrumb[] = (object)[
            'id'   => $product->id,
            'name' => $product->name,
            'slug' => $product->slug
        ];

        require __DIR__ . '/../Views/product.view.php';
    }
}
