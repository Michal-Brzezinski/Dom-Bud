<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Core\Database;

class CategoryService
{
    private CategoryRepository $repo;

    public function __construct()
    {
        $config = require __DIR__ . '/../Config/config.php';
        $pdo = Database::getConnection($config['db']);
        $this->repo = new CategoryRepository($pdo);
    }

    public function findBySlug(string $slug)
    {
        return $this->repo->findBySlug($slug);
    }

    public function getChildren(int $id): array
    {
        return $this->repo->findChildren($id);
    }

    public function getRootCategories(): array
    {
        return $this->repo->findRootCategories();
    }

    public function getBreadcrumb(int $id): array
    {
        return $this->repo->getBreadcrumb($id);
    }

    public function getPublishedRootCategories(): array
    {
        return $this->repo->getPublishedRoot();
    }

    public function getPublishedChildren(int $id): array
    {
        return $this->repo->findPublishedChildren($id);
    }
}
