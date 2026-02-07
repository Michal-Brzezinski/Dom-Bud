<?php

namespace App\Services;

class ProductService
{
    private string $file;

    public function __construct()
    {
        $this->file = __DIR__ . '/../../public/data/products.json';
    }

    public function getAll(): array
    {
        return json_decode(file_get_contents($this->file), true);
    }

    public function getProductsByCategory(string $category): array
    {
        $products = $this->getAll();

        return array_values(array_filter($products, function ($p) use ($category) {
            return isset($p['category']) && $p['category'] === $category;
        }));
    }

    public function getCategoryName(string $slug): string
    {
        $map = [
            'chemia-budowlana' => 'Chemia budowlana',
            'instalacje-elektryczne' => 'Instalacje elektryczne',
            'instalacje-wodno-kanalizacyjne-i-wentylacyjne' => 'Instalacje wodno-kanalizacyjne i wentylacyjne',
            'malowanie-i-wykonczenie' => 'Malowanie i wykończenie',
            'materialy-konstrukcyjne' => 'Materiały konstrukcyjne',
            'narzedzia' => 'Narzędzia',
            'odziez-i-bhp' => 'Odzież i środki BHP',
            'pokrycia-dachowe' => 'Pokrycia dachowe',
            'systemy-docieplen' => 'Systemy dociepleń',
            'systemy-mocowan' => 'Systemy mocowań'
        ];

        return $map[$slug] ?? $slug;
    }
}
