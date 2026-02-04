<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;

$router = new Router();

// Strony statyczne
$router->get('', 'HomeController', 'index');
$router->get('o-nas', 'AboutController', 'index');
$router->get('katalog', 'CatalogController', 'index');

// Kontakt
$router->get('kontakt', 'ContactController', 'showForm');
$router->post('kontakt/send', 'ContactController', 'handle');

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

$router->run($path);
