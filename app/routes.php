<?php

$router->get('', 'HomeController', 'index');
$router->get('o-nas', 'AboutController', 'index');

$router->get('katalog', 'CatalogController', 'index');
$router->get('katalog/{category}', 'CatalogController', 'category');

$router->get('kontakt', 'ContactController', 'showForm');
$router->post('kontakt/send', 'ContactController', 'handle');
