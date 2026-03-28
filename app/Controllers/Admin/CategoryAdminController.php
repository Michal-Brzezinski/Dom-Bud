<?php

namespace App\Controllers\Admin;

use App\Services\AuthService;
use App\Services\CategoryAdminService;

class CategoryAdminController
{
    private AuthService $auth;
    private CategoryAdminService $categories;

    public function __construct()
    {
        $this->auth = new AuthService();
        $this->categories = new CategoryAdminService();
    }

    public function index()
    {
        $this->auth->requireLogin();
        $categories = $this->categories->all();
        require __DIR__ . '/../../Views/admin/categories/index.view.php';
    }

    public function create()
    {
        $this->auth->requireLogin();
        require __DIR__ . '/../../Views/admin/categories/create.view.php';
    }

    public function store()
    {
        $this->auth->requireLogin();
        $this->categories->create($_POST);
        header('Location: /admin/categories');
    }

    public function edit()
    {
        $this->auth->requireLogin();
        $category = $this->categories->find($_GET['id']);
        require __DIR__ . '/../../Views/admin/categories/edit.view.php';
    }

    public function update()
    {
        $this->auth->requireLogin();
        $this->categories->update($_POST['id'], $_POST);
        header('Location: /admin/categories');
    }

    public function delete()
    {
        $this->auth->requireLogin();
        $this->categories->delete($_POST['id']);
        header('Location: /admin/categories');
    }
}
