<?php

namespace App\Repositories;

use PDO;
use App\Models\Category;

class CategoryRepository
{
    public function __construct(private PDO $pdo) {}

    public function findBySlug(string $slug): ?Category
    {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE slug = ?");
        $stmt->execute([$slug]);
        $row = $stmt->fetch();

        return $row ? new Category($row) : null;
    }

    public function findChildren(int $parentId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE parent_id = ?");
        $stmt->execute([$parentId]);
        $rows = $stmt->fetchAll();

        return array_map(fn($r) => new Category($r), $rows);
    }

    public function findRootCategories(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM categories WHERE parent_id IS NULL");
        $rows = $stmt->fetchAll();

        return array_map(fn($r) => new Category($r), $rows);
    }

    public function getBreadcrumb(int $categoryId): array
    {
        $breadcrumb = [];

        while ($categoryId !== null) {
            $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = ?");
            $stmt->execute([$categoryId]);
            $row = $stmt->fetch();

            if (!$row) {
                break;
            }

            $category = new Category($row);
            $breadcrumb[] = $category;
            $categoryId = $category->parent_id;
        }

        return array_reverse($breadcrumb);
    }
}
