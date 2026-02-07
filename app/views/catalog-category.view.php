<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $categoryName ?></title>
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/cta.css">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="site">

    <?php include __DIR__ . '/partials/navbar.php'; ?>

    <section class="catalog-header">
        <h2 class="catalog-header__title"><?= $categoryName ?></h2>
        <p class="catalog-header__text">Produkty w tej kategorii.</p>
    </section>

    <section class="products">

        <?php include __DIR__ . '/partials/catalog-controls.php'; ?>

        <?php if (empty($products)): ?>
            <div class="products__error">Brak produktów w tej kategorii.</div>
        <?php else: ?>
            <div class="products__grid">

                <!-- render kart -->
                <?php foreach ($products as $p): ?>
                    <div class="products__card">
                        <div class="products__image-wrapper">
                            <img src="/<?= $p['image'] ?>" class="products__image">
                        </div>
                        <div class="products__content">
                            <h3 class="products__title"><?= $p['name'] ?></h3>
                            <p class="products__description"><?= $p['description'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <?php include __DIR__ . '/partials/footer.php'; ?>

    <script type="module" src="/js/catalog/category-products.js"></script>
    <script type="module" src="/js/catalog/products-search.js"></script>
    <script type="module" src="/js/catalog/products-sort.js"></script>
    <script type="module" src="/js/navbar.js"></script>

</body>

</html>