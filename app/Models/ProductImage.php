<?php

namespace App\Models;

class ProductImage
{
    public int $id;
    public int $product_id;
    public string $path;
    public ?string $alt;
    public bool $is_main;
    public int $sort_order;
    public ?string $created_at;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->id = (int)$data['id'];
            $this->product_id = (int)$data['product_id'];
            $this->path = $data['path'];
            $this->alt = $data['alt'] ?? null;
            $this->is_main = (bool)$data['is_main'];
            $this->sort_order = (int)$data['sort_order'];
            $this->created_at = $data['created_at'] ?? null;
        }
    }
}
