<?php

namespace App\Controllers;

use App\Services\AuthService;

class AuthController
{
    private AuthService $auth;

    public function __construct()
    {
        $this->auth = new AuthService();
    }

    /**
     * GET /admin/login
     */
    public function loginForm(): void
    {
        // Jeśli admin już zalogowany → przekieruj do panelu
        if ($this->auth->currentUser()) {
            header('Location: /admin');
            exit;
        }

        $error = $_GET['error'] ?? null;

        require __DIR__ . '/../Views/admin/login.view.php';
    }

    /**
     * POST /admin/login
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo "Method Not Allowed";
            return;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Walidacja pustych pól
        if ($email === '' || $password === '') {
            header('Location: /admin/login?error=empty');
            exit;
        }

        // Próba logowania
        if (!$this->auth->login($email, $password)) {
            header('Location: /admin/login?error=invalid');
            exit;
        }

        // Sukces
        header('Location: /admin');
        exit;
    }

    /**
     * GET /admin/logout
     */
    public function logout(): void
    {
        $this->auth->logout();
        header('Location: /admin/login');
        exit;
    }
}
