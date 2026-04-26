<?php

/** @var array $categoriesFlat */ ?>

<link rel="icon" href="<?= asset('img/dom-bud_logo.webp') ?>" type="image/webp" loading="lazy">
<title>Kategorie — Panel admina</title>

<link rel="stylesheet" href="<?= asset('css/admin/_import.css') ?>">
<link rel="stylesheet" href="<?= asset('css/admin/categories-view/_import.css') ?>">

<div class="admin-container">

    <div class="page-header">
        <div class="page-header__left">
            <a class="page-header__back" href="/admin">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
                Panel główny
            </a>
            <h1>Kategorie</h1>
        </div>

        <a class="btn btn--primary" href="/admin/categories/create">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Dodaj kategorię
        </a>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert--error">
            <?= htmlspecialchars($_GET['error'], ENT_QUOTES) ?>
        </div>
    <?php endif; ?>

    <?php if (empty($categoriesFlat)): ?>
        <div class="empty-state">
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

                <tbody id="cat-table-body">

                    <?php foreach ($categoriesFlat as $row): ?>
                        <?php
                        $cat           = $row['cat'];
                        $depth         = (int)$row['depth'];
                        $childrenCount = (int)$row['children_count'];
                        $hasChildren   = $childrenCount > 0;

                        if ($cat->has_draft) {
                            $statusClass = 'status--draft';
                            $statusLabel = 'Szkic';
                        } elseif ($cat->is_published) {
                            $statusClass = 'status--published';
                            $statusLabel = 'Opublikowana';
                        } else {
                            $statusClass = 'status--unpublished';
                            $statusLabel = 'Nieopublikowana';
                        }
                        ?>

                        <tr class="cat-row depth-<?= $depth ?>"
                            data-id="<?= (int)$cat->id ?>"
                            data-parent="<?= (int)$cat->parent_id ?>"
                            data-depth="<?= $depth ?>">

                            <td colspan="5" class="cat-row-wrapper">
                                <div class="cat-row-inner">

                                    <table class="cat-inner-table">
                                        <tr>

                                            <td class="cat-thumb">
                                                <?php if ($cat->image_path): ?>
                                                    <img src="/<?= htmlspecialchars($cat->image_path) ?>" alt="">
                                                <?php else: ?>
                                                    <div class="cat-thumb__placeholder"></div>
                                                <?php endif; ?>
                                            </td>

                                            <td class="cat-name">
                                                <div class="cat-name__inner">

                                                    <?php if ($hasChildren): ?>
                                                        <!-- STRZAŁKA = rozwijalna -->
                                                        <span class="cat-toggle js-cat-toggle"
                                                            data-id="<?= (int)$cat->id ?>">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                width="14" height="14"
                                                                viewBox="0 0 24 24"
                                                                fill="none" stroke="currentColor"
                                                                stroke-width="2">
                                                                <polyline points="9 18 15 12 9 6" />
                                                            </svg>
                                                        </span>
                                                    <?php else: ?>
                                                        <!-- FOLDER = brak podkategorii -->
                                                        <span class="cat-toggle cat-toggle--leaf">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                width="14" height="14"
                                                                viewBox="0 0 24 24"
                                                                fill="none" stroke="currentColor"
                                                                stroke-width="2">
                                                                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z" />
                                                            </svg>
                                                        </span>
                                                    <?php endif; ?>

                                                    <?= htmlspecialchars($cat->name) ?>

                                                    <?php if ($hasChildren): ?>
                                                        <span class="cat-badge cat-badge--children">
                                                            <?= $childrenCount ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>

                                            <td class="cat-slug">
                                                <code><?= htmlspecialchars($cat->slug) ?></code>
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
                                                        href="/admin/categories/<?= htmlspecialchars($cat->slug) ?>/edit">
                                                        Edytuj
                                                    </a>

                                                    <?php if (!$hasChildren): ?>
                                                        <a class="btn btn--sm btn--secondary"
                                                            href="/admin/categories/<?= htmlspecialchars($cat->slug) ?>/products">
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
                                    </table>

                                </div>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>

    <?php endif; ?>
</div>

<script src="<?= asset('js/admin/categories-toggle.js') ?>"></script>