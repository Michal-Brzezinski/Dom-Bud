<?php

/**
 * Funkcja paginacji - tworzy nawigację po stronach
 * 
 * @param string $baseUrl - Bazowy URL (np. url('katalog/narzedzia'))
 * @param int $page - Aktualna strona
 * @param int $totalPages - Całkowita liczba stron
 * @param array $params - Dodatkowe parametry GET (np. ['sort' => 'az', 'q' => 'młotek'])
 */
function pagination(string $baseUrl, int $page, int $totalPages, array $params = [])
{
    if ($totalPages <= 1) return;

    $build = function ($p) use ($baseUrl, $params) {
        // Usuń trailing slash z baseUrl jeśli istnieje
        $baseUrl = rtrim($baseUrl, '/');

        // Zbuduj query string
        $queryParams = array_merge($params, ['page' => $p]);

        // Usuń puste wartości
        $queryParams = array_filter($queryParams, function ($value) {
            return $value !== '' && $value !== null;
        });

        return $baseUrl . '?' . http_build_query($queryParams);
    };

    echo '<nav class="pagination">';

    // Poprzednia strona
    echo '<a class="pagination__btn' . ($page == 1 ? ' pagination__btn--disabled' : '') . '" href="' . ($page > 1 ? $build($page - 1) : '#') . '">‹</a>';

    // Pierwsza strona
    echo '<a class="pagination__btn' . ($page == 1 ? ' pagination__btn--active' : '') . '" href="' . $build(1) . '">1</a>';

    // Elipsa przed
    if ($page > 3) echo '<span class="pagination__dots">…</span>';

    // Strony środkowe
    for ($i = max(2, $page - 1); $i <= min($totalPages - 1, $page + 1); $i++) {
        echo '<a class="pagination__btn' . ($page == $i ? ' pagination__btn--active' : '') . '" href="' . $build($i) . '">' . $i . '</a>';
    }

    // Elipsa po
    if ($page < $totalPages - 2) echo '<span class="pagination__dots">…</span>';

    // Ostatnia strona
    if ($totalPages > 1) {
        echo '<a class="pagination__btn' . ($page == $totalPages ? ' pagination__btn--active' : '') . '" href="' . $build($totalPages) . '">' . $totalPages . '</a>';
    }

    // Następna strona
    echo '<a class="pagination__btn' . ($page == $totalPages ? ' pagination__btn--disabled' : '') . '" href="' . ($page < $totalPages ? $build($page + 1) : '#') . '">›</a>';

    echo '</nav>';
}
