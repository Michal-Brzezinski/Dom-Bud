<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Strona nie została znaleziona</title>
    <link rel="icon" href="<?= asset('img/dom-bud_logo.webp') ?>" type="image/webp" loading="lazy">
    <link rel="stylesheet" href="<?= asset('css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/footer.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/404.css') ?>">

</head>

<body class="site" data-base-url="<?= htmlspecialchars($GLOBALS['baseUrl'] ?? '') ?>">

    <?php include __DIR__ . '/partials/navbar.php'; ?>

    <section class="error-page">
        <div class="error-page__code">404</div>
        <h2 class="error-page__title">Ups! Ta strona nie istnieje</h2>
        <p class="error-page__text">
            Wygląda na to, że trafiłeś na nieistniejącą podstronę.<br>
            Sprawdź adres lub wróć na stronę główną.
        </p>

        <a href="<?= url() ?>" class="error-page__button">Wróć do strony głównej</a>
    </section>

    <?php include __DIR__ . '/partials/footer.php'; ?>

    <script type="module" src="<?= asset('js/navbar.js') ?>"></script>

</body>

</html>