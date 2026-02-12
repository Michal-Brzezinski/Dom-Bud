<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($categoryName) ?> - DOM-BUD</title>
    <link rel="icon" href="<?= asset('img/dom-bud_logo.webp') ?>" type="image/webp">
    <link rel="stylesheet" href="<?= asset('css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/footer.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/cta.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/scroll-up.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/catalog/catalog-controls.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/catalog/products.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/components/modal.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/components/pagination.css') ?>">
</head>

<body class="site" data-base-url="<?= htmlspecialchars($GLOBALS['baseUrl'] ?? '') ?>">

    <?php include __DIR__ . '/partials/navbar.php'; ?>

    <section class="catalog-header">
        <h2 class="catalog-header__title"><?= htmlspecialchars($categoryName) ?></h2>
        <p class="catalog-header__text">Wybierz produkt, aby zobaczyć szczegóły.</p>
    </section>

    <?php include __DIR__ . '/partials/catalog-controls.php'; ?>

    <section class="products">
        <div class="products__grid">
            <?php if (empty($products)): ?>
                <div class="products__error">Brak produktów w tej kategorii.</div>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <div class="products__card">
                        <div class="products__image-wrapper">
                            <img src="<?= asset($product['image']) ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>"
                                class="products__image"
                                loading="lazy">
                        </div>
                        <div class="products__content">
                            <h3 class="products__title"><?= htmlspecialchars($product['name']) ?></h3>
                            <p class="products__description"><?= htmlspecialchars($product['description']) ?></p>
                            <span class="products__more">Kliknij, aby zobaczyć więcej →</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <?php if ($totalPages > 1): ?>
        <?php
        include __DIR__ . '/partials/pagination.php';
        pagination(
            url('katalog/' . $category),
            $page,
            $totalPages,
            ['sort' => $sort, 'q' => $q]
        );
        ?>
    <?php endif; ?>

    <?php include __DIR__ . '/partials/cta.php'; ?>
    <?php include __DIR__ . '/partials/footer.php'; ?>

    <button id="scrollUp" class="scroll-up">
        <img src="<?= asset('img/icons/arrow-up.svg') ?>" alt="Scroll up" />
    </button>

    <script type="module" src="<?= asset('js/catalog/category-products.js') ?>"></script>
    <script type="module" src="<?= asset('js/navbar.js') ?>"></script>
    <script type="module" src="<?= asset('js/scroll-up.js') ?>"></script>

</body>

</html>