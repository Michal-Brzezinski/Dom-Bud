<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOM-BUD - Katalog produktów</title>
    <link rel="icon" href="<?= asset('img/dom-bud_logo.webp') ?>" type="image/webp">
    <link rel="stylesheet" href="<?= asset('css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/footer.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/cta.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/scroll-up.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/components/breadcrumb.css') ?>">
</head>

<body class="site" data-base-url="<?= htmlspecialchars($GLOBALS['baseUrl'] ?? '') ?>">

    <?php include __DIR__ . '/partials/navbar.php'; ?>

    <?php if (isset($breadcrumb)): ?>
        <?php include __DIR__ . '/partials/breadcrumb.php'; ?>
    <?php endif; ?>

    <section class="catalog-header">
        <h2 class="catalog-header__title">
            <?= $category ? htmlspecialchars($category->name) : 'Katalog produktów' ?>
        </h2>

        <p class="catalog-header__text">
            <?= $category ? 'Wybierz kategorię produktów.' : 'Wybierz kategorię produktów.' ?>
        </p>
    </section>

    <section class="products">
        <div class="categories__grid">

            <?php foreach ($categories as $cat): ?>
                <a href="<?= url('katalog/' . $cat->slug) ?>" class="category-card">

                    <div class="category-card__left">
                        <img src="<?= asset($cat->getImage()) ?>"
                            alt="<?= htmlspecialchars($cat->name) ?>"
                            loading="lazy">
                        <h3 class="category-card__title">
                            <?= htmlspecialchars($cat->name) ?>
                        </h3>
                    </div>

                    <div class="category-card__right">
                        <p class="category-card__description"
                            title="<?= htmlspecialchars($cat->description) ?>">
                            <?= htmlspecialchars($cat->description) ?>
                        </p>
                        <span class="category-card__link">Przejdź do kategorii →</span>
                    </div>

                </a>
            <?php endforeach; ?>

        </div>
    </section>

    <?php include __DIR__ . '/partials/cta.php'; ?>
    <?php include __DIR__ . '/partials/footer.php'; ?>

    <button id="scrollUp" class="scroll-up">
        <img src="<?= asset('img/icons/arrow-up.svg') ?>" alt="Scroll up" />
    </button>

    <script type="module" src="<?= asset('js/scroll-up.js') ?>"></script>
    <script src="<?= asset('js/navbar.js') ?>"></script>

</body>

</html>