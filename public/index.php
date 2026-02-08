<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/bootstrap.php';

use App\Core\Router;

$router = new Router();

require __DIR__ . '/../app/routes.php';

$router->run($_SERVER['REQUEST_URI']);
