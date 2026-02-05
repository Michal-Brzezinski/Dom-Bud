<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Strona nie została znaleziona</title>
    <link rel="icon" href="/img/dom-bud_logo.png" type="image/webp">
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/404.css">

</head>

<body class="site">

    <?php include __DIR__ . '/partials/navbar.php'; ?>

    <section class="error-page">
        <div class="error-page__code">404</div>
        <h2 class="error-page__title">Ups! Ta strona nie istnieje</h2>
        <p class="error-page__text">
            Wygląda na to, że trafiłeś na nieistniejącą podstronę.<br>
            Sprawdź adres lub wróć na stronę główną.
        </p>

        <a href="/" class="error-page__button">Wróć do strony głównej</a>
    </section>

    <?php include __DIR__ . '/partials/footer.php'; ?>


</body>

</html>