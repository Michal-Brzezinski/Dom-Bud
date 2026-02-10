<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOM-BUD - Katalog produktów</title>
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/cta.css">
    <link rel="stylesheet" href="/css/scroll-up.css">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="site">

    <?php include __DIR__ . '/partials/navbar.php'; ?>

    <section class="catalog-header">
        <h2 class="catalog-header__title">Katalog produktów</h2>
        <p class="catalog-header__text">Wybierz kategorię produktów.</p>
    </section>

    <section class="products">
        <div class="categories__grid">

            <?php
            $categories = [
                ['slug' => 'chemia-budowlana', 'name' => 'Chemia budowlana', 'desc' => 'Kleje, piany montażowe, silikony, grunty i inne produkty chemii budowlanej.'],
                ['slug' => 'instalacje-elektryczne', 'name' => 'Instalacje elektryczne', 'desc' => 'Przewody, osprzęt elektryczny, zabezpieczenia i akcesoria instalacyjne.'],
                ['slug' => 'instalacje-wodno-kanalizacyjne-i-wentylacyjne', 'name' => 'Instalacje wodno-kanalizacyjne i wentylacyjne', 'desc' => 'Rury, kształtki, złączki, kanały, kratki i inne elementy instalacj wodno-kanalizacyjnej i wentylacyjnej'],
                ['slug' => 'malowanie-i-wykonczenie', 'name' => 'Malowanie i wykończenie', 'desc' => 'Farby, pędzle, wałki, taśmy malarskie oraz akcesoria do prac wykończeniowych.'],
                ['slug' => 'materialy-konstrukcyjne', 'name' => 'Materiały konstrukcyjne', 'desc' => 'Bloczki, pustaki, cegły oraz inne ciężkie materiały budowlane.'],
                ['slug' => 'narzedzia', 'name' => 'Narzędzia', 'desc' => 'Narzędzia ręczne i akcesoria niezbędne przy pracach budowlanych i remontowych.'],
                ['slug' => 'odziez-i-srodki-bhp', 'name' => 'Odzież i środki BHP', 'desc' => 'Odzież robocza, rękawice, kaski oraz środki ochrony osobistej na budowie.'],
                ['slug' => 'pokrycia-dachowe', 'name' => 'Pokrycia dachowe', 'desc' => 'Dachówki oraz akcesoria dachowe do kompleksowego wykonania dachu.'],
                ['slug' => 'systemy-docieplen', 'name' => 'Systemy dociepleń', 'desc' => 'Kompletne systemy ociepleń budynków: styropian, wełna, kleje, siatki, tynki i akcesoria.'],
                ['slug' => 'systemy-mocowan', 'name' => 'Systemy mocowań', 'desc' => 'Kołki, wkręty, śruby, kotwy oraz elementy montażowe do różnych zastosowań.'],
            ];

            foreach ($categories as $cat): ?>
                <a href="/katalog/<?= $cat['slug'] ?>" class="category-card">

                    <div class="category-card__left">
                        <img src="/img/categories/<?= $cat['slug'] ?>.jpg" alt="<?= $cat['name'] ?>">
                        <h3 class="category-card__title"><?= $cat['name'] ?></h3>
                    </div>

                    <div class="category-card__right">
                        <p class="category-card__description" title="<?= $cat['desc'] ?>">
                            <?= $cat['desc'] ?>
                        </p>
                        <span class="category-card__link">Przejdź do kategorii →</span>
                    </div>

                </a>
            <?php endforeach; ?>

        </div>
    </section>

    <?php include __DIR__ . '/partials/cta.php'; ?>
    <?php include __DIR__ . '/partials/footer.php'; ?>

    <button id="scrollUp" class="scroll-up">🢁</button>

    <script type="module" src="/js/scroll-up.js"></script>
    <script type="module" src="/js/navbar.js"></script>

</body>

</html>