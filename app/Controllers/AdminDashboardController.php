<?php

namespace App\Controllers;

use App\Services\AuthService;

class AdminDashboardController
{
    private AuthService $auth;

    public function __construct()
    {
        $this->auth = new AuthService();
    }

    public function index(): void
    {
        $this->auth->requireLogin();

        require __DIR__ . '/../Views/admin/dashboard.view.php';
    }
}
