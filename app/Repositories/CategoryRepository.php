<?php

namespace App\Repositories;

use PDO;
use App\Models\Category;

class CategoryRepository
{
    public function __construct(private PDO $pdo) {}

    // =============================
    // Dodatkowe metody pomocnicze
    // =============================

    private function map(?array $row): ?Category
    {
        return $row ? new Category($row) : null;
    }

    private function mapAll(array $rows): array
    {
        return array_map(fn($row) => new Category($row), $rows);
    }

    private function normalizeParentId($value): ?int
    {
        if ($value === null || $value === '' || !is_numeric($value)) {
            return null;
        }

        return (int)$value;
    }

    // =============================
    // Metody repozytorium
    // =============================

    public function findBySlug(string $slug): ?Category
    {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE slug = ?");
        $stmt->execute([$slug]);

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return $this->map($row);
    }

    public function findChildren(int $parentId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE parent_id = :parent_id");
        $stmt->execute(['parent_id' => $parentId]);

        return $this->mapAll($stmt->fetchAll());
    }

    public function findRootCategories(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM categories WHERE parent_id IS NULL");

        return $this->mapAll($stmt->fetchAll());
    }

    public function getBreadcrumb(int $categoryId): array
    {
        $breadcrumb = [];

        while ($categoryId) {
            $category = $this->find($categoryId);
            if (!$category) break;

            $breadcrumb[] = $category;
            $categoryId = $category->parent_id;
        }

        return array_reverse($breadcrumb);
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM categories ORDER BY name ASC');

        return $this->mapAll($stmt->fetchAll());
    }

    public function find(int $id): ?Category
    {
        $stmt = $this->pdo->prepare('SELECT * FROM categories WHERE id = :id');
        $stmt->execute(['id' => $id]);

        return $this->map($stmt->fetch());
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO categories (name, slug, description, image_path, parent_id, is_published)
            VALUES (:name, :slug, :description, :image_path, :parent_id, :is_published)
        ');

        $stmt->execute([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'image_path' => $data['image_path'] ?? null,
            'parent_id' => $this->normalizeParentId($data['parent_id']),
            'is_published' => $data['is_published'] ?? 1,
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->pdo->prepare('
            UPDATE categories
            SET name = :name,
                slug = :slug,
                description = :description,
                image_path = :image_path,
                parent_id = :parent_id,
                is_published = :is_published
            WHERE id = :id
        ');

        $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'image_path' => $data['image_path'] ?? null,
            'parent_id' => $this->normalizeParentId($data['parent_id']),
            'is_published' => $data['is_published'] ?? 1,
        ]);
    }

    public function updateDraft(int $id, array $data): void
    {
        $stmt = $this->pdo->prepare('
            UPDATE categories
            SET draft_name = :draft_name,
                draft_slug = :draft_slug,
                draft_description = :draft_description,
                draft_image_path = :draft_image_path,
                draft_parent_id = :draft_parent_id,
                has_draft = :has_draft
            WHERE id = :id
        ');

        $stmt->execute([
            'id' => $id,
            'draft_name' => $data['draft_name'],
            'draft_slug' => $data['draft_slug'],
            'draft_description' => $data['draft_description'],
            'draft_image_path' => $data['draft_image_path'],
            'draft_parent_id' => $this->normalizeParentId($data['draft_parent_id']),
            'has_draft' => true,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM categories WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function getPublishedRoot(): array
    {
        $stmt = $this->pdo->query("
            SELECT * FROM categories
            WHERE parent_id IS NULL AND is_published = 1
            ORDER BY name ASC
        ");

        return $this->mapAll($stmt->fetchAll());
    }

    public function findPublished(int $id): ?Category
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM categories
            WHERE id = :id AND is_published = 1
        ");
        $stmt->execute(['id' => $id]);

        return $this->map($stmt->fetch());
    }

    public function findPublishedChildren(int $parentId): array
    {
        $stmt = $this->pdo->prepare("
        SELECT *
        FROM categories
        WHERE parent_id = :parent_id
          AND is_published = 1
        ORDER BY name ASC
    ");

        $stmt->execute(['parent_id' => $parentId]);

        return $this->mapAll($stmt->fetchAll());
    }

    public function publish(int $id, array $data): void
    {
        $stmt = $this->pdo->prepare('
            UPDATE categories
            SET name = :name,
                slug = :slug,
                description = :description,
                image_path = :image_path,
                parent_id = :parent_id,
                is_published = 1,
                draft_name = NULL,
                draft_slug = NULL,
                draft_description = NULL,
                draft_image_path = NULL,
                draft_parent_id = NULL,
                has_draft = 0
            WHERE id = :id
        ');

        $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'],
            'image_path' => $data['image_path'],
            'parent_id' => $this->normalizeParentId($data['parent_id']),
        ]);
    }
}
