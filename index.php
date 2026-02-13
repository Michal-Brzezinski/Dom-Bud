<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/bootstrap.php';

use App\Core\Router;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$router = new Router();

require __DIR__ . '/app/routes.php';

$router->run($_SERVER['REQUEST_URI']);
