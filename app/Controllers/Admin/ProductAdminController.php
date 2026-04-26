<?php

namespace App\Controllers\Admin;

use App\Services\AuthService;
use App\Services\ProductAdminService;
use App\Repositories\ProductRepository;
use App\Repositories\ProductImageRepository;
use App\Repositories\CategoryRepository;
use App\Core\Database;

class ProductAdminController
{
    private AuthService $auth;
    private ProductAdminService $products;
    private CategoryRepository $categories;

    public function __construct()
    {
        $this->auth = new AuthService();

        // Inicjalizacja repozytoriów
        $config = require ROOT_PATH . '/app/Config/config.php';
        $pdo = Database::getConnection($config['db']);

        $productRepo = new ProductRepository($pdo);
        $imageRepo   = new ProductImageRepository($pdo);

        $this->products   = new ProductAdminService($productRepo, $imageRepo);
        $this->categories = new CategoryRepository($pdo);
    }

    /**
     * Lista produktów w wybranej kategorii
     */
    public function index()
    {
        $this->auth->requireLogin();

        $categoryId = (int)($_GET['category_id'] ?? 0);
        $category   = $this->categories->find($categoryId);

        if (!$category) {
            header('Location: /admin/categories?error=' . urlencode('Nie znaleziono kategorii.'));
            return;
        }

        $products = $this->products->getByCategory($categoryId);

        require ROOT_PATH . '/app/Views/admin/products/index.view.php';
    }

    /**
     * Formularz dodawania produktu
     */
    public function create()
    {
        $this->auth->requireLogin();

        $categoryId = (int)($_GET['category_id'] ?? 0);
        $category   = $this->categories->find($categoryId);

        if (!$category) {
            header('Location: /admin/categories?error=' . urlencode('Nie znaleziono kategorii.'));
            return;
        }

        require ROOT_PATH . '/app/Views/admin/products/create.view.php';
    }

    /**
     * Zapis nowego produktu
     */
    public function store()
    {
        $this->auth->requireLogin();

        $categoryId = (int)($_POST['category_id'] ?? 0);
        $category   = $this->categories->find($categoryId);

        if (!$category) {
            header('Location: /admin/categories?error=' . urlencode('Nie znaleziono kategorii.'));
            return;
        }

        $name  = trim($_POST['name'] ?? '');
        $price = (float)($_POST['price'] ?? 0);
        $desc  = $_POST['description'] ?? null;
        $propsRaw = $_POST['properties'] ?? '';

        $properties = null;
        if ($propsRaw !== '') {
            try {
                $decoded = json_decode($propsRaw, true, 512, JSON_THROW_ON_ERROR);
                $properties = $decoded;
            } catch (\Throwable $e) {
                header('Location: /admin/products/create?category_id=' . $categoryId .
                    '&error=' . urlencode('Niepoprawny JSON we właściwościach.'));
                return;
            }
        }

        if ($name === '' || $price < 0) {
            header('Location: /admin/products/create?category_id=' . $categoryId .
                '&error=' . urlencode('Uzupełnij nazwę i poprawną cenę.'));
            return;
        }

        $data = [
            'category_id' => $categoryId,
            'name'        => $name,
            'price'       => $price,
            'description' => $desc,
            'properties'  => $properties,
        ];

        $product = $this->products->createProduct($data);

        $this->products->moveTempImagesToProduct(
            $product->id,
            $product->slug
        );

        // przekierowanie na listę produktów po slugu kategorii
        header('Location: /admin/categories/' . $category->slug . '/products');
    }

    /**
     * Formularz edycji produktu
     */
    public function edit()
    {
        $this->auth->requireLogin();

        $id = (int)($_GET['id'] ?? 0);
        $product = $this->products->find($id);

        if (!$product) {
            header('Location: /admin/categories?error=' . urlencode('Nie znaleziono produktu.'));
            return;
        }

        $categories = $this->categories->getAll();

        require ROOT_PATH . '/app/Views/admin/products/edit.view.php';
    }


    /**
     * Aktualizacja produktu
     */
    public function update()
    {
        $this->auth->requireLogin();

        $id = (int)($_POST['id'] ?? 0);
        if (!$id) {
            header('Location: /admin/categories?error=' . urlencode('Brak ID produktu.'));
            return;
        }

        $product = $this->products->find($id);
        if (!$product) {
            header('Location: /admin/categories?error=' . urlencode('Nie znaleziono produktu.'));
            return;
        }

        $name  = trim($_POST['name'] ?? '');
        $price = (float)($_POST['price'] ?? 0);
        $desc  = $_POST['description'] ?? null;
        $propsRaw = $_POST['properties'] ?? '';

        $properties = null;
        if ($propsRaw !== '') {
            try {
                $decoded = json_decode($propsRaw, true, 512, JSON_THROW_ON_ERROR);
                $properties = $decoded;
            } catch (\Throwable $e) {
                header('Location: /admin/products/edit?id=' . $id .
                    '&error=' . urlencode('Niepoprawny JSON we właściwościach.'));
                return;
            }
        }

        if ($name === '' || $price < 0) {
            header('Location: /admin/products/edit?id=' . $id .
                '&error=' . urlencode('Uzupełnij nazwę i poprawną cenę.'));
            return;
        }

        $data = [
            'name'        => $name,
            'price'       => $price,
            'description' => $desc,
            'properties'  => $properties,
        ];

        try {
            $this->products->updateProduct($id, $data);
        } catch (\Exception $e) {
            header('Location: /admin/products/edit?id=' . $id .
                '&error=' . urlencode($e->getMessage()));
            return;
        }

        // mamy w modelu product->category_slug (z joinem w repozytorium)
        $categorySlug = $product->category_slug ?? null;

        if ($categorySlug) {
            header('Location: /admin/categories/' . $categorySlug . '/products');
        } else {
            // fallback gdyby coś poszło nie tak
            header('Location: /admin/products?category_id=' . $product->category_id);
        }
    }

    /**
     * Usuwanie produktu
     */
    public function delete()
    {
        $this->auth->requireLogin();

        $id = (int)($_POST['id'] ?? 0);
        $this->products->delete($id);

        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/admin/categories'));
    }

    /**
     * Upload zdjęcia produktu
     */
    public function uploadImage()
    {
        $this->auth->requireLogin();

        header('Content-Type: application/json; charset=utf-8');

        $productId = (int)($_POST['product_id'] ?? 0);
        $action = $_POST['action'] ?? null;

        if (!$productId) {
            echo json_encode(['error' => 'Brak ID produktu']);
            return;
        }

        // 1. Ustawianie zdjęcia głównego
        if ($action === 'set_main') {
            $imageId = (int)($_POST['image_id'] ?? 0);
            $this->products->setMainImage($productId, $imageId);

            echo json_encode(['success' => true]);
            return;
        }

        // 2. Usuwanie zdjęcia
        if ($action === 'delete') {
            $imageId = (int)($_POST['image_id'] ?? 0);
            $this->products->deleteImage($productId, $imageId);

            echo json_encode(['success' => true]);
            return;
        }

        // 3. Upload nowego zdjęcia
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['error' => 'Brak pliku lub błąd uploadu']);
            return;
        }

        try {
            $path = $this->products->uploadImage($productId, $_FILES['image']);
            echo json_encode(['success' => true, 'path' => $path]);
        } catch (\Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function uploadImageTemp()
    {
        $this->auth->requireLogin();
        header('Content-Type: application/json; charset=utf-8');

        // SESJA JEST JUŻ STARTOWANA W bootstrap.php → NIE RUSZAMY JEJ TUTAJ

        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['error' => 'Brak pliku lub błąd uploadu']);
            return;
        }

        $sessionId = session_id();
        $dir = ROOT_PATH . "/uploads/tmp/products/$sessionId";

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($ext, $allowed)) {
            echo json_encode(['error' => 'Niedozwolony format pliku']);
            return;
        }

        $filename = uniqid("tmp_") . "." . $ext;
        $path = "$dir/$filename";

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
            echo json_encode(['error' => 'Nie udało się zapisać pliku']);
            return;
        }

        if (!isset($_SESSION['temp_images'])) {
            $_SESSION['temp_images'] = [];
        }

        $_SESSION['temp_images'][] = $filename;

        echo json_encode([
            'success' => true,
            'filename' => $filename,
            'session'  => $sessionId,
        ]);
    }

    // ============================

    public function indexBySlug(string $slug)
    {
        $this->auth->requireLogin();

        $category = $this->categories->findBySlug($slug);
        if (!$category) {
            header('Location: /admin/categories?error=' . urlencode('Nie znaleziono kategorii.'));
            return;
        }

        $products = $this->products->getByCategory($category->id);

        require ROOT_PATH . '/app/Views/admin/products/index.view.php';
    }

    public function createBySlug(string $slug)
    {
        $this->auth->requireLogin();

        $category = $this->categories->findBySlug($slug);
        if (!$category) {
            header('Location: /admin/categories?error=' . urlencode('Nie znaleziono kategorii.'));
            return;
        }

        require ROOT_PATH . '/app/Views/admin/products/create.view.php';
    }

    public function storeBySlug(string $slug)
    {
        $this->auth->requireLogin();

        $category = $this->categories->findBySlug($slug);
        if (!$category) {
            header('Location: /admin/categories?error=' . urlencode('Nie znaleziono kategorii.'));
            return;
        }

        // TODO: implementacja zapisu produktu
        echo "TODO: storeBySlug()";
    }

    public function deleteTempImage()
    {
        $this->auth->requireLogin();
        header('Content-Type: application/json; charset=utf-8');

        $sessionId = session_id();
        $filename = $_POST['filename'] ?? null;

        if (!$filename) {
            echo json_encode(['error' => 'Brak nazwy pliku']);
            return;
        }

        $path = ROOT_PATH . "/uploads/tmp/products/$sessionId/$filename";

        if (is_file($path)) {
            unlink($path);
        }

        $_SESSION['temp_images'] = array_values(
            array_filter($_SESSION['temp_images'] ?? [], fn($f) => $f !== $filename)
        );

        echo json_encode(['success' => true, 'session' => $sessionId]);
    }

    public function setTempMainImage()
    {
        $this->auth->requireLogin();
        header('Content-Type: application/json; charset=utf-8');

        $sessionId = session_id();
        $filename = $_POST['filename'] ?? null;

        if (!$filename) {
            echo json_encode(['error' => 'Brak nazwy pliku']);
            return;
        }

        $_SESSION['temp_main_image'] = $filename;

        echo json_encode(['success' => true, 'session' => $sessionId]);
    }

    public function listTempImages()
    {
        $this->auth->requireLogin();
        header('Content-Type: application/json; charset=utf-8');

        $sessionId = session_id();

        echo json_encode([
            'images'  => $_SESSION['temp_images'] ?? [],
            'main'    => $_SESSION['temp_main_image'] ?? null,
            'session' => $sessionId,
        ]);
    }

    public function clearTemp()
    {
        $this->auth->requireLogin();
        header('Content-Type: application/json; charset=utf-8');

        $sessionId = session_id();
        $tmpDir = ROOT_PATH . "/uploads/tmp/products/$sessionId";

        if (is_dir($tmpDir)) {
            foreach (glob("$tmpDir/*") as $f) {
                @unlink($f);
            }
            @rmdir($tmpDir);
        }

        unset($_SESSION['temp_images'], $_SESSION['temp_main_image']);

        echo json_encode(['success' => true, 'session' => $sessionId]);
    }
}
