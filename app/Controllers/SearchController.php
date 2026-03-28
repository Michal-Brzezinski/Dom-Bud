<?php

// namespace App\Controllers;

// use App\Services\CategoryService;
// use App\Services\ProductService;

// class SearchController
// {
//     public function search(): void
//     {
//         header('Content-Type: application/json');

//         $q = trim($_GET['q'] ?? '');

//         if ($q === '') {
//             echo json_encode([]);
//             return;
//         }

//         $categoryService = new CategoryService();
//         $productService  = new ProductService();

//         // 1. Szukaj kategorii
//         $categories = $categoryService->searchByName($q);

//         // 2. Szukaj produktów
//         $products = $productService->searchProducts($q);

//         echo json_encode([
//             'categories' => $categories,
//             'products'   => $products
//         ]);
//     }
// }
