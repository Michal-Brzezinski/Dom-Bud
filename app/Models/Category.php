<?php

namespace App\Models;

class Category
{
    public int $id;
    public ?int $parent_id;
    public string $name;
    public string $slug;
    public ?string $description;
    public ?string $image_path;
    public int $is_published;

    // POLA DRAFTU
    public ?string $draft_name;
    public ?string $draft_slug;
    public ?string $draft_description;
    public ?string $draft_image_path;
    public ?int $draft_parent_id;
    public int $has_draft;

    public function __construct(array $data)
    {
        $this->id = (int)$data['id'];
        $this->parent_id = $data['parent_id'] !== null ? (int)$data['parent_id'] : null;

        $this->name = $data['name'];
        $this->slug = $data['slug'];
        $this->description = $data['description'] ?? null;
        $this->image_path = $data['image_path'] ?? null;

        $this->is_published = isset($data['is_published']) ? (int)$data['is_published'] : 1;

        // POLA DRAFTU
        $this->draft_name = $data['draft_name'] ?? null;
        $this->draft_slug = $data['draft_slug'] ?? null;
        $this->draft_description = $data['draft_description'] ?? null;
        $this->draft_image_path = $data['draft_image_path'] ?? null;
        $this->draft_parent_id = isset($data['draft_parent_id']) ? (int)$data['draft_parent_id'] : null;
        $this->has_draft = isset($data['has_draft']) ? (int)$data['has_draft'] : 0;
    }

    public function getImage(): string
    {
        return $this->image_path ?: 'img/placeholder.webp';
    }
}
