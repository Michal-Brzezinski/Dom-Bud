<?php

namespace App\Models;

class Product
{
    public int $id;
    public string $name;
    public string $category;
    public float $price;
    public ?string $description;
    public array $properties;
    /** @var ProductImage[] */
    public array $images = [];

    public function __construct(array $data)
    {
        $this->id = (int)$data['id'];
        $this->name = $data['name'];
        $this->category = $data['category'];
        $this->price = (float)$data['price'];
        $this->description = $data['description'] ?? null;
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
