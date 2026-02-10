<?php

namespace App\Repositories;

class ProductRepository
{
    private string $file;

    public function __construct()
    {
        $this->file = __DIR__ . '/../../public/data/products.json';
    }

    private function load(): array
    {
        return json_decode(file_get_contents($this->file), true);
    }

    public function getByCategory(string $category): array
    {
        return array_values(array_filter(
            $this->load(),
            fn($p) => $p['category'] === $category
        ));
    }

    public function search(array $products, string $query): array
    {
        if ($query === '') return $products;

        $q = mb_strtolower($query);

        return array_values(array_filter(
            $products,
            fn($p) => str_contains(mb_strtolower($p['name']), $q)
        ));
    }

    public function sort(array $products, string $mode): array
    {
        usort($products, function ($a, $b) use ($mode) {
            return $mode === 'za'
                ? strcmp($b['name'], $a['name'])
                : strcmp($a['name'], $b['name']);
        });

        return $products;
    }

    public function paginate(array $products, int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;
        return array_slice($products, $offset, $perPage);
    }
}
