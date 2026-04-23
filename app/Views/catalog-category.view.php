<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($category->name) ?> - DOM-BUD</title>
    <link rel="icon" href="<?= asset('img/dom-bud_logo.webp') ?>" type="image/webp">
    <link rel="stylesheet" href="<?= asset('css/common/navbar.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/common/side-panel.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/common/footer.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/common/cta.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/common/scroll-up.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/common/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/catalog/catalog-controls.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/components/modal.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/components/pagination.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/components/breadcrumb.css') ?>">
</head>

<body class="site" data-base-url="<?= htmlspecialchars($GLOBALS['baseUrl'] ?? '') ?>">

    <?php include __DIR__ . '/partials/navbar.php'; ?>

    <?php if (isset($breadcrumb)): ?>
        <?php include __DIR__ . '/partials/breadcrumb.php'; ?>
    <?php endif; ?>

    <section class="catalog-header">
        <h2 class="catalog-header__title"><?= htmlspecialchars($category->name) ?></h2>
        <p class="catalog-header__text">Wybierz produkt, aby zobaczyć szczegóły.</p>
    </section>

    <?php include __DIR__ . '/partials/catalog-controls.php'; ?>

    <section class="products">
        <div class="products__grid">
            <?php if (empty($products)): ?>
                <div class="products__error">Brak produktów w tej kategorii.</div>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <a href="<?= url('katalog/' . $category->slug . '/' . $product->slug) ?>" class="products__card">
                        <div class="products__image-wrapper">
                            <?php
                            $mainImage = $product->getMainImage();
                            $path = $mainImage ? $mainImage->path : 'img/placeholder.webp';
                            ?>
                            <img src="<?= asset($path) ?>"
                                alt="<?= htmlspecialchars($product->name) ?>"
                                class="products__image"
                                loading="lazy">
                        </div>
                        <div class="products__content">
                            <h3 class="products__title"><?= htmlspecialchars($product->name) ?></h3>
                            <p class="products__description"><?= htmlspecialchars($product->description) ?></p>
                            <span class="products__more">Kliknij, aby zobaczyć więcej →</span>
                        </div>
                    </a>
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

    <script src="<?= asset('js/navbar.js') ?>"></script>
    <script type="module" src="<?= asset('js/scroll-up.js') ?>"></script>

</body>

</html>