<?php

namespace App\Repositories;

class ProductRepository
{
    private string $file;

    public function __construct()
    {
        // POPRAWKA: Użyj względnej ścieżki która zadziała w każdym środowisku
        // Poprzednio: __DIR__ . '/../../public/data/products.json'
        // Problem: Nazwa katalogu 'public' jest hardcoded

        // Rozwiązanie 1: Względna ścieżka od app/Repositories/
        $this->file = __DIR__ . '/../../public_html/data/products.json';

        // Rozwiązanie 2 (lepsze): Użyj document root jeśli dostępny
        // Zadziała zarówno lokalnie jak i na hostingu
        if (isset($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['DOCUMENT_ROOT'])) {
            $this->file = $_SERVER['DOCUMENT_ROOT'] . '/data/products.json';
        } else {
            // Fallback dla CLI lub jeśli DOCUMENT_ROOT nie jest ustawiony
            $this->file = __DIR__ . '/../../public_html/data/products.json';
        }
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
        // Użyj Collator dla prawidłowego sortowania polskich znaków
        if (class_exists('Collator')) {
            $collator = new \Collator('pl_PL');

            usort($products, function ($a, $b) use ($mode, $collator) {
                $result = $collator->compare($a['name'], $b['name']);
                return $mode === 'za' ? -$result : $result;
            });
        } else {
            // Fallback: użyj setlocale i strcoll
            $currentLocale = setlocale(LC_COLLATE, 0);
            setlocale(LC_COLLATE, 'pl_PL.UTF-8', 'pl_PL', 'polish');

            usort($products, function ($a, $b) use ($mode) {
                $result = strcoll($a['name'], $b['name']);
                return $mode === 'za' ? -$result : $result;
            });

            // Przywróć poprzednią lokalizację
            setlocale(LC_COLLATE, $currentLocale);
        }

        return $products;
    }

    public function paginate(array $products, int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;
        return array_slice($products, $offset, $perPage);
    }
}
