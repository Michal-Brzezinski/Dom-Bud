<?php

namespace App\Repositories;

class ProductRepository
{
    private string $file;

    public function __construct()
    {
        $this->file = __DIR__ . '/../../data/products.json';
    }

    private function load(): array
    {
        if (!file_exists($this->file)) {
            // Dodaj informacyjny błąd jeśli plik nie istnieje
            trigger_error("Plik products.json nie został znaleziony: {$this->file}", E_USER_WARNING);
            return [];
        }

        return json_decode(file_get_contents($this->file), true) ?? [];
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
        // 1. Próba użycia Collator (najlepsza opcja)
        if (class_exists('Collator')) {
            $collator = new \Collator('pl_PL');

            // Sprawdź, czy Collator faktycznie używa polskiej lokalizacji
            $validLocale = $collator->getLocale(\Locale::VALID_LOCALE);

            if (str_starts_with($validLocale, 'pl')) {
                usort($products, function ($a, $b) use ($mode, $collator) {
                    $result = $collator->compare($a['name'], $b['name']);
                    return $mode === 'za' ? -$result : $result;
                });

                return $products;
            }
        }

        // 2. Próba użycia setlocale + strcoll
        $currentLocale = setlocale(LC_COLLATE, 0);
        $localeSet = setlocale(LC_COLLATE, 'pl_PL.UTF-8', 'pl_PL', 'polish');

        if ($localeSet !== false) {
            usort($products, function ($a, $b) use ($mode) {
                $result = strcoll($a['name'], $b['name']);
                return $mode === 'za' ? -$result : $result;
            });

            setlocale(LC_COLLATE, $currentLocale);
            return $products;
        }

        // 3. Fallback: własna mapa sortowania (działa wszędzie)
        $map = [
            'ą' => 'a',
            'ć' => 'c',
            'ę' => 'e',
            'ł' => 'l',
            'ń' => 'n',
            'ó' => 'o',
            'ś' => 's',
            'ź' => 'z',
            'ż' => 'z',
            'Ą' => 'A',
            'Ć' => 'C',
            'Ę' => 'E',
            'Ł' => 'L',
            'Ń' => 'N',
            'Ó' => 'O',
            'Ś' => 'S',
            'Ź' => 'Z',
            'Ż' => 'Z',
        ];

        usort($products, function ($a, $b) use ($mode, $map) {
            $an = strtr($a['name'], $map);
            $bn = strtr($b['name'], $map);

            $result = strcmp($an, $bn);
            return $mode === 'za' ? -$result : $result;
        });

        return $products;
    }

    public function paginate(array $products, int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;
        return array_slice($products, $offset, $perPage);
    }
}
