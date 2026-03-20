<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Core\Database;

class ProductService
{
    private ProductRepository $repo;

    public function __construct()
    {
        $config = require __DIR__ . '/../Config/config.php';
        $pdo = Database::getConnection($config['db']);
        $this->repo = new ProductRepository($pdo);
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
        return $this->repo->getProductsByCategory($category, $q, $sort);
    }
}
