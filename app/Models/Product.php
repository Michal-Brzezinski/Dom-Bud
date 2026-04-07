<?php

namespace App\Models;

class Product
{
    public int $id;
    public string $name;
    public ?int $category_id;
    public float $price;
    public ?string $description;
    public string $category_slug;
    public array $properties;
    public string $slug;
    public ?string $main_image_path = null;
    /** @var ProductImage[] */
    public array $images = [];

    public function __construct(array $data)
    {
        $this->id = (int)$data['id'];
        $this->name = $data['name'];
        $this->category_id = isset($data['category_id']) ? (int)$data['category_id'] : null;
        $this->price = (float)$data['price'];
        $this->description = $data['description'] ?? null;
        $this->category_slug = $data['category_slug'] ?? '';
        $this->main_image_path = $data['main_image_path'] ?? null;
        $this->slug = $data['slug'] ?? null;
        $this->properties = json_decode($data['properties'] ?? '[]', true) ?? [];
    }

    public function addImage(ProductImage $image): void
    {
        $this->images[] = $image;
    }

    public function getMainImage(): ?ProductImage
    {
        foreach ($this->images as $img) {
            if ($img->is_main) {
                return $img;
            }
        }

        return $this->images[0] ?? null;
    }
}
