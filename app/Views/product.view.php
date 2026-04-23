<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($product->name) ?> - DOM-BUD</title>

    <link rel="icon" href="<?= asset('img/dom-bud_logo.webp') ?>" type="image/webp">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?= asset('css/common/navbar.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/common/side-panel.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/common/footer.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/common/cta.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/common/scroll-up.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/common/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/components/breadcrumb.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/product/product.css') ?>">
</head>

<body class="site" data-base-url="<?= htmlspecialchars($GLOBALS['baseUrl'] ?? '') ?>">

    <?php include __DIR__ . '/partials/navbar.php'; ?>
    <?php include __DIR__ . '/partials/breadcrumb.php'; ?>

    <section class="product-page">

        <!-- LEWA KOLUMNA: GALERIA -->
        <div class="product-gallery">

            <!-- GŁÓWNY SLIDER -->
            <div class="swiper product-swiper-main">
                <div class="swiper-wrapper">
                    <?php foreach ($images as $img): ?>
                        <div class="swiper-slide">
                            <img src="<?= asset($img->path) ?>" alt="<?= htmlspecialchars($product->name) ?>">
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (count($images) > 1): ?>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                <?php endif; ?>
            </div>

            <!-- MINIATURY -->
            <?php if (count($images) > 1): ?>
                <div class="swiper product-swiper-thumbs">
                    <div class="swiper-wrapper">
                        <?php foreach ($images as $img): ?>
                            <div class="swiper-slide">
                                <img src="<?= asset($img->path) ?>" alt="<?= htmlspecialchars($product->name) ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <!-- PRAWA KOLUMNA: INFORMACJE -->
        <div class="product-info">

            <h1 class="product-title"><?= htmlspecialchars($product->name) ?></h1>

            <div class="product-price-box">
                <p class="product-price"><?= number_format($product->price, 2) ?> zł</p>

                <a href="<?= url('kontakt') ?>" class="product-cta">
                    Zapytaj o produkt
                </a>
            </div>

            <?php if (!empty($properties)): ?>
                <ul class="product-properties">
                    <?php foreach ($properties as $key => $value): ?>
                        <li>
                            <span class="prop-key"><?= htmlspecialchars($key) ?></span>
                            <span class="prop-value"><?= htmlspecialchars($value) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

        </div>

    </section>

    <!-- OPIS PRODUKTU -->
    <section class="product-description-section">
        <h2>Opis produktu</h2>
        <p><?= nl2br(htmlspecialchars($product->description)) ?></p>
    </section>



    <?php include __DIR__ . '/partials/cta.php'; ?>
    <?php include __DIR__ . '/partials/footer.php'; ?>

    <button id="scrollUp" class="scroll-up">
        <img src="<?= asset('img/icons/arrow-up.svg') ?>" alt="Scroll up" />
    </button>

    <script src="<?= asset('js/navbar.js') ?>"></script>
    <script type="module" src="<?= asset('js/scroll-up.js') ?>"></script>
    <script type="module" src="<?= asset('js/catalog/swiper.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

</body>

</html>