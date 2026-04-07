<?php

namespace App\Controllers\Admin;

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

        require ROOT_PATH . '/app/Views/admin/dashboard.view.php';
    }
}
