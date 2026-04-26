<?php

namespace App\Controllers\Admin;

use App\Services\AuthService;
use App\Services\CategoryAdminService;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProductImageRepository;
use App\Services\ProductAdminService;
use App\Core\Database;

class CategoryAdminController
{
    private AuthService $auth;
    private CategoryAdminService $categories;

    public function __construct()
    {
        $this->auth = new AuthService();

        $config = require ROOT_PATH . '/app/Config/config.php';
        $pdo    = Database::getConnection($config['db']);

        $categoryRepo = new CategoryRepository($pdo);
        $productRepo  = new ProductRepository($pdo);
        $imageRepo    = new ProductImageRepository($pdo);

        $productAdmin = new ProductAdminService($productRepo, $imageRepo);

        $this->categories = new CategoryAdminService($categoryRepo, $productAdmin);
    }

    public function index()
    {
        $this->auth->requireLogin();

        // Spłaszczone drzewo z poziomami
        $categoriesFlat = $this->categories->getTreeFlat();

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
            $isPublish = ($_POST['action'] ?? '') === 'publish';

            $data = [
                'name'         => $_POST['name'] ?? '',
                'slug'         => $_POST['slug'] ?? '',
                'description'  => $_POST['description'] ?? null,
                'image_path'   => $_POST['draft_image_path'] ?? null,
                'parent_id'    => $_POST['parent_id'] ?? null,
                'is_published' => $isPublish ? 1 : 0
            ];

            $this->categories->create($data);

            header('Location: /admin/categories');
        } catch (\Exception $e) {
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

    public function editBySlug(string $slug)
    {
        $this->auth->requireLogin();

        $category = $this->categories->findBySlug($slug);
        if (!$category) {
            header('Location: /admin/categories?error=' . urlencode('Nie znaleziono kategorii.'));
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
                'name'            => $_POST['name'] ?? '',
                'slug'            => $_POST['slug'] ?? '',
                'description'     => $_POST['description'] ?? null,
                'draft_image_path' => $_POST['draft_image_path'] ?? null,
                'parent_id'       => $_POST['parent_id'] ?? null
            ];

            if (isset($_POST['publish_now'])) {

                // 1. Zapisz draft
                $this->categories->update($id, $data);

                // 2. Opublikuj
                $this->categories->publish($id);

                header('Location: /admin/categories');
                return;
            }

            $this->categories->update($id, $data);

            header('Location: /admin/categories');
        } catch (\Exception $e) {
            header('Location: /admin/categories/edit?id=' . $id . '&error=' . urlencode($e->getMessage()));
        }
    }


    public function delete()
    {
        $this->auth->requireLogin();
        $this->categories->deleteRecursive((int)$_POST['id']);
        header('Location: /admin/categories');
    }

    public function uploadImage(): void
    {
        $this->auth->requireLogin();

        header('Content-Type: application/json; charset=utf-8');

        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo json_encode(['error' => 'Brak pliku lub błąd przesyłania']);
            return;
        }

        try {
            $path = $this->categories->uploadCategoryImage(
                $_FILES['image'],
                $_POST['slug'] ?? 'kategoria',
                $_POST['current_path'] ?? null
            );

            echo json_encode([
                'success' => true,
                'path'    => $path
            ]);
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
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
