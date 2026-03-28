<?php

namespace App\Controllers\Admin;

use App\Services\AuthService;
use App\Services\CategoryAdminService;
use App\Repositories\CategoryRepository;
use App\Core\Database;

class CategoryAdminController
{
    private AuthService $auth;
    private CategoryAdminService $categories;

    public function __construct()
    {
        $this->auth = new AuthService();

        // Inicjalizacja zależności (DI)
        $config = require ROOT_PATH . '/app/Config/config.php'; // Dopasuj ścieżkę do configu!
        $pdo = Database::getConnection($config['db']);
        $repo = new CategoryRepository($pdo);
        $this->categories = new CategoryAdminService($repo);
    }

    public function index()
    {
        $this->auth->requireLogin();
        $categories = $this->categories->all();
        require ROOT_PATH . '/app/Views/admin/categories/index.view.php';
    }

    public function create()
    {
        $this->auth->requireLogin();
        $categories = $this->categories->all();
        require ROOT_PATH . '/app/Views/admin/categories/create.view.php';
    }

    public function store()
    {
        $this->auth->requireLogin();

        try {
            // Filtrowanie i przekazywanie ścisłego zestawu danych
            $data = [
                'name' => $_POST['name'] ?? '',
                'slug' => $_POST['slug'] ?? '',
                'description' => $_POST['description'] ?? null,
                'image_path' => $_POST['draft_image_path'] ?? null,
                'parent_id' => $_POST['parent_id'] ?? '',
                'is_published' => isset($_POST['is_published']) ? 1 : 0
            ];

            $this->categories->create($data);
            header('Location: /admin/categories');
        } catch (\Exception $e) {
            // W docelowej apce zamień to na mechanizm sesyjnych Flash Messages
            header('Location: /admin/categories/create?error=' . urlencode('Wystąpił błąd podczas dodawania.'));
        }
    }

    public function edit()
    {
        $this->auth->requireLogin();
        $category = $this->categories->find((int)$_GET['id']);
        if (!$category) {
            header('Location: /admin/categories');
            return;
        }

        $categories = $this->categories->all();
        require ROOT_PATH . '/app/Views/admin/categories/edit.view.php';
    }


    public function update()
    {
        $this->auth->requireLogin();

        try {
            $id = (int)$_POST['id'];
            $data = [
                'name' => $_POST['name'] ?? '',
                'slug' => $_POST['slug'] ?? '',
                'description' => $_POST['description'] ?? null,
                'draft_image_path' => $_POST['draft_image_path'] ?? null,
                'parent_id' => $_POST['parent_id'] ?? ''
            ];

            $this->categories->update($id, $data);
            header('Location: /admin/categories');
        } catch (\Exception $e) {
            header('Location: /admin/categories/edit?id=' . $_POST['id'] . '&error=' . urlencode($e->getMessage()));
        }
    }

    public function delete()
    {
        $this->auth->requireLogin();
        $this->categories->delete((int)$_POST['id']);
        header('Location: /admin/categories');
    }

    public function uploadImage(): void
    {
        $this->auth->requireLogin();

        header('Content-Type: application/json; charset=utf-8');

        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo json_encode(['error' => 'Brak pliku lub błąd przesyłania']);
            exit;
        }

        $file = $_FILES['file'];

        // MIME detection (twój kod)
        $mimeType = null;
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);
        }
        if (!$mimeType && function_exists('mime_content_type')) {
            $mimeType = mime_content_type($file['tmp_name']);
        }
        if (!$mimeType) {
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $map = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp'];
            $mimeType = $map[$ext] ?? 'application/octet-stream';
        }

        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($mimeType, $allowedMimes)) {
            http_response_code(400);
            echo json_encode(['error' => 'Nieprawidłowy format pliku']);
            exit;
        }

        if (!@getimagesize($file['tmp_name'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Plik nie jest obrazem']);
            exit;
        }

        // USUWANIE POPRZEDNIEGO PLIKU SZKICU
        if (!empty($_POST['current_path'])) {
            $old = ROOT_PATH . '/' . ltrim($_POST['current_path'], '/');
            if (is_file($old)) {
                @unlink($old);
            }
        }

        // generowanie nowej nazwy
        $rawSlug = $_POST['slug'] ?? 'kategoria';
        $safeSlug = preg_replace('/[^a-z0-9-]/', '-', strtolower($rawSlug));

        $year = date('Y');
        $month = date('m');
        $dir = ROOT_PATH . "/uploads/categories/$year/$month/";

        if (!is_dir($dir)) mkdir($dir, 0777, true);

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) $ext = 'jpg';

        $hash = substr(md5(uniqid('', true)), 0, 6);
        $filename = "{$safeSlug}_{$hash}.{$ext}";
        $path = $dir . $filename;

        if (move_uploaded_file($file['tmp_name'], $path)) {
            $publicPath = "uploads/categories/$year/$month/$filename";

            echo json_encode([
                'success' => true,
                'path' => $publicPath
            ]);
            exit;
        }

        http_response_code(500);
        echo json_encode(['error' => 'Błąd zapisu pliku']);
        exit;
    }

    public function publish()
    {
        $this->auth->requireLogin();

        try {
            $id = (int)$_POST['id'];
            $this->categories->publish($id);
            header('Location: /admin/categories');
        } catch (\Exception $e) {
            header('Location: /admin/categories?error=' . urlencode($e->getMessage()));
        }
    }
}
