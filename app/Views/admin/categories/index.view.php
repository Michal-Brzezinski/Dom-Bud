<?php

/** @var array $categoriesFlat */
?>

<link rel="icon" href="<?= asset('img/dom-bud_logo.webp') ?>" type="image/webp" loading="lazy">
<title>Kategorie — Panel admina</title>
<link rel="stylesheet" href="<?= asset('css/admin/_import.css') ?>">
<link rel="stylesheet" href="<?= asset('css/admin/categories-view/_import.css') ?>">

<div class="admin-container">

    <div class="page-header">
        <div class="page-header__left">
            <a class="page-header__back" href="/admin">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
                Panel główny
            </a>
            <h1>Kategorie</h1>
        </div>
        <a class="btn btn--primary" href="/admin/categories/create">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Dodaj kategorię
        </a>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert--error">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" y1="8" x2="12" y2="12" />
                <line x1="12" y1="16" x2="12.01" y2="16" />
            </svg>
            <?= htmlspecialchars($_GET['error'], ENT_QUOTES) ?>
        </div>
    <?php endif; ?>

    <?php if (empty($categoriesFlat)): ?>
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="1">
                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z" />
            </svg>
            <p>Brak kategorii. <a href="/admin/categories/create">Dodaj pierwszą</a>.</p>
        </div>
    <?php else: ?>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Miniatura</th>
                        <th>Nazwa</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Akcje</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($categoriesFlat as $row): ?>
                        <?php
                        /** @var \App\Models\Category $cat */
                        $cat           = $row['cat'];
                        $depth         = (int)$row['depth'];
                        $childrenCount = (int)$row['children_count'];
                        $hasChildren   = $childrenCount > 0;

                        // Status
                        if ((int)$cat->has_draft === 1) {
                            $statusClass = 'status--draft';
                            $statusLabel = 'Szkic';
                        } elseif ((int)$cat->is_published === 1) {
                            $statusClass = 'status--published';
                            $statusLabel = 'Opublikowana';
                        } else {
                            $statusClass = 'status--unpublished';
                            $statusLabel = 'Nieopublikowana';
                        }
                        ?>
                        <tr class="cat-row depth-<?= $depth ?>" data-depth="<?= $depth ?>">

                            <td class="cat-thumb">
                                <?php if ($cat->image_path): ?>
                                    <img src="/<?= htmlspecialchars($cat->image_path, ENT_QUOTES) ?>"
                                        alt="<?= htmlspecialchars($cat->name, ENT_QUOTES) ?>"
                                        loading="lazy">
                                <?php else: ?>
                                    <div class="cat-thumb__placeholder">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="3" width="18" height="18" rx="2" />
                                            <circle cx="8.5" cy="8.5" r="1.5" />
                                            <polyline points="21 15 16 10 5 21" />
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </td>

                            <td class="cat-name">
                                <div class="cat-name__inner">
                                    <?php if ($depth > 0): ?>
                                        <span class="cat-indent">
                                            <?php for ($i = 1; $i < $depth; $i++): ?>
                                                <span class="cat-indent__line"></span>
                                            <?php endfor; ?>
                                            <span class="cat-indent__connector"></span>
                                        </span>
                                    <?php endif; ?>

                                    <span class="cat-name__text">
                                        <?php if ($depth === 0 || $hasChildren): ?>
                                            <svg class="cat-icon" xmlns="http://www.w3.org/2000/svg"
                                                width="14" height="14"
                                                viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z" />
                                            </svg>
                                        <?php else: ?>
                                            <svg class="cat-icon" xmlns="http://www.w3.org/2000/svg"
                                                width="14" height="14"
                                                viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="9 18 15 12 9 6" />
                                            </svg>
                                        <?php endif; ?>
                                        <?= htmlspecialchars($cat->name, ENT_QUOTES) ?>
                                    </span>

                                    <?php if ($hasChildren): ?>
                                        <span class="cat-badge cat-badge--children">
                                            <?= $childrenCount ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <td class="cat-slug">
                                <code><?= htmlspecialchars($cat->slug, ENT_QUOTES) ?></code>
                            </td>

                            <td>
                                <span class="cat-status <?= $statusClass ?>">
                                    <span class="cat-status__dot"></span>
                                    <?= $statusLabel ?>
                                </span>
                            </td>

                            <td class="cat-actions">
                                <div class="actions-wrapper">
                                    <a class="btn btn--sm"
                                        href="/admin/categories/<?= htmlspecialchars($cat->slug, ENT_QUOTES) ?>/edit">
                                        Edytuj
                                    </a>

                                    <?php if (!$hasChildren): ?>
                                        <a class="btn btn--sm btn--secondary"
                                            href="/admin/categories/<?= htmlspecialchars($cat->slug, ENT_QUOTES) ?>/products">
                                            Produkty
                                        </a>
                                    <?php endif; ?>

                                    <form class="inline" method="post" action="/admin/categories/delete"
                                        onsubmit="return confirm('Usunąć kategorię <?= addslashes($cat->name) ?> i wszystkie jej produkty?');">
                                        <input type="hidden" name="id" value="<?= (int)$cat->id ?>">
                                        <button class="btn btn--sm btn-danger" type="submit">Usuń</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>
</div>