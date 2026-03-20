<?php

namespace App\Services;

use App\Core\Database;
use App\Repositories\AdminRepository;

class AuthService
{
    private AdminRepository $repo;

    public function __construct()
    {
        $config = require __DIR__ . '/../Config/config.php';
        $pdo = Database::getConnection($config['db']);
        $this->repo = new AdminRepository($pdo);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login(string $email, string $password): bool
    {
        $email = trim($email);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $admin = $this->repo->findByEmail($email);

        if (!$admin) {
            return false;
        }

        if (!password_verify($password, $admin->password)) {
            return false;
        }

        $_SESSION['admin_id'] = $admin->id;

        return true;
    }

    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
    }

    public function currentUser()
    {
        if (!isset($_SESSION['admin_id'])) {
            return null;
        }

        return $this->repo->findById($_SESSION['admin_id']);
    }

    public function requireLogin(): void
    {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /admin/login');
            exit;
        }
    }

    public function sanitize(string $value): string
    {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }
}
