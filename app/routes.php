<?php

$router->get('', 'HomeController', 'index');
$router->get('o-nas', 'AboutController', 'index');

$router->get('katalog', 'CatalogController', 'index');
$router->get('katalog/{category}', 'CatalogController', 'category');

$router->get('kontakt', 'ContactController', 'showForm');
$router->post('kontakt/send', 'ContactController', 'handle');

$router->get('admin/login', 'Admin\AuthController', 'loginForm');
$router->post('admin/login', 'Admin\AuthController', 'login');
$router->get('admin/logout', 'Admin\AuthController', 'logout');

$router->get('admin', 'Admin\AdminDashboardController', 'index'); // placeholder

$router->get('admin/categories', 'Admin\CategoryAdminController', 'index');
$router->get('admin/categories/create', 'Admin\CategoryAdminController', 'create');
$router->post('admin/categories/store', 'Admin\CategoryAdminController', 'store');
$router->get('admin/categories/edit', 'Admin\CategoryAdminController', 'edit');
$router->post('admin/categories/update', 'Admin\CategoryAdminController', 'update');
$router->post('admin/categories/delete', 'Admin\CategoryAdminController', 'delete');
