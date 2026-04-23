<?php

$router->get('', 'HomeController', 'index');
$router->get('o-nas', 'AboutController', 'index');

$router->get('katalog', 'CatalogController', 'index');
$router->get('katalog/{category}', 'CatalogController', 'category');

$router->get('katalog/{category}/{product}', 'CatalogController', 'product');

$router->get('kontakt', 'ContactController', 'showForm');
$router->post('kontakt/send', 'ContactController', 'handle');

$router->get('admin/login', 'Admin\AuthController', 'loginForm');
$router->post('admin/login', 'Admin\AuthController', 'login');
$router->get('admin/logout', 'Admin\AuthController', 'logout');

$router->get('admin', 'Admin\AdminDashboardController', 'index'); // placeholder


// Category AdminPanel routes

$router->get('admin/categories', 'Admin\CategoryAdminController', 'index');
$router->get('admin/categories/create', 'Admin\CategoryAdminController', 'create');
$router->post('admin/categories/store', 'Admin\CategoryAdminController', 'store');
$router->get('admin/categories/{slug}/edit', 'Admin\CategoryAdminController', 'editBySlug');
$router->post('admin/categories/update', 'Admin\CategoryAdminController', 'update');
$router->post('admin/categories/upload-image', 'Admin\CategoryAdminController', 'uploadImage');
$router->post('admin/categories/delete', 'Admin\CategoryAdminController', 'delete');
$router->post('admin/categories/publish', 'Admin\CategoryAdminController', 'publish');

// Product AdminPanel routes — routing oparty o slug kategorii
$router->get('admin/categories/{slug}/products', 'Admin\ProductAdminController', 'indexBySlug');
$router->get('admin/categories/{slug}/products/create', 'Admin\ProductAdminController', 'createBySlug');
$router->post('admin/categories/{slug}/products/store', 'Admin\ProductAdminController', 'storeBySlug');


// Product AdminPanel routes
$router->get('admin/products', 'Admin\ProductAdminController', 'index');
$router->get('admin/products/create', 'Admin\ProductAdminController', 'create');
$router->post('admin/products/store', 'Admin\ProductAdminController', 'store');
$router->get('admin/products/edit', 'Admin\ProductAdminController', 'edit');
$router->post('admin/products/update', 'Admin\ProductAdminController', 'update');
$router->post('admin/products/delete', 'Admin\ProductAdminController', 'delete');
$router->post('admin/products/upload-image', 'Admin\ProductAdminController', 'uploadImage');
$router->post('admin/products/upload-image-temp', 'Admin\ProductAdminController', 'uploadImageTemp');
