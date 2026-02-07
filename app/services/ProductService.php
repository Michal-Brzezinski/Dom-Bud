<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    private ProductRepository $repo;

    public function __construct()
    {
        $this->repo = new ProductRepository();
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

    public function getFilteredProducts(string $category, string $q, string $sort): array
    {
        $products = $this->repo->getByCategory($category);
        $products = $this->repo->search($products, $q);
        $products = $this->repo->sort($products, $sort);

        return $products;
    }
}
