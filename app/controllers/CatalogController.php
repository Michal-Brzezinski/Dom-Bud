<?php

namespace App\Controllers;

class CatalogController
{
    public function index(): void
    {
        require __DIR__ . '/../views/catalog.view.php';
    }
}
