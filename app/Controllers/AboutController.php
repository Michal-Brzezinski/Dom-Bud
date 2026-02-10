<?php

namespace App\Controllers;

class AboutController
{
    public function index(): void
    {
        require __DIR__ . '/../Views/about.view.php';
    }
}
