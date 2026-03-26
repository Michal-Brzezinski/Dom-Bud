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

    public function __construct(array $data)
    {
        $this->id = (int)$data['id'];
        $this->parent_id = $data['parent_id'] !== null ? (int)$data['parent_id'] : null;
        $this->name = $data['name'];
        $this->slug = $data['slug'];
        $this->description = $data['description'] ?? null;
        $this->image_path = $data['image_path'] ?? null;
    }
}
