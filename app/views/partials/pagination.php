<?php
function pagination(string $baseUrl, int $page, int $totalPages, array $params = [])
{
    if ($totalPages <= 1) return;

    $build = function ($p) use ($baseUrl, $params) {
        return $baseUrl . '?' . http_build_query(array_merge($params, ['page' => $p]));
    };

    echo '<nav class="pagination">';

    // poprzednia
    echo '<a class="pagination__btn' . ($page == 1 ? ' pagination__btn--disabled' : '') . '" href="' . ($page > 1 ? $build($page - 1) : '#') . '">‹</a>';

    // 1
    echo '<a class="pagination__btn' . ($page == 1 ? ' pagination__btn--active' : '') . '" href="' . $build(1) . '">1</a>';

    // elipsa
    if ($page > 3) echo '<span class="pagination__dots">…</span>';

    // środek
    for ($i = max(2, $page - 1); $i <= min($totalPages - 1, $page + 1); $i++) {
        echo '<a class="pagination__btn' . ($page == $i ? ' pagination__btn--active' : '') . '" href="' . $build($i) . '">' . $i . '</a>';
    }

    // elipsa
    if ($page < $totalPages - 2) echo '<span class="pagination__dots">…</span>';

    // ostatnia
    if ($totalPages > 1) {
        echo '<a class="pagination__btn' . ($page == $totalPages ? ' pagination__btn--active' : '') . '" href="' . $build($totalPages) . '">' . $totalPages . '</a>';
    }

    // następna
    echo '<a class="pagination__btn' . ($page == $totalPages ? ' pagination__btn--disabled' : '') . '" href="' . ($page < $totalPages ? $build($page + 1) : '#') . '">›</a>';

    echo '</nav>';
}
