<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DOM-BUD Skład Budowlany</title>
  <link rel="icon" href="/img/dom-bud_logo.webp" type="image/webp">
  <link rel="stylesheet" href="/css/navbar.css">
  <link rel="stylesheet" href="/css/footer.css">
  <link rel="stylesheet" href="/css/cta.css">
  <link rel="stylesheet" href="/css/scroll-up.css">
  <link rel="stylesheet" href="/css/style.css">
</head>

<body class="site">

  <?php include __DIR__ . '/partials/navbar.php'; ?>

  <section class="hero">
    <div class="hero__content">
      <h2 class="hero__title">DOM-BUD</h2>
      <h3 class="hero__subtitle">Twój zaufany skład budowlany</h3>
      <p class="hero__text">
        Od ponad 20 lat dostarczamy materiały budowlane najwyższej jakości.
        Wspieramy klientów indywidualnych i firmy, oferując doradztwo, transport i profesjonalną obsługę.
      </p>
      <a href="/katalog" class="hero__button">Sprawdź ofertę</a>
    </div>
  </section>

  <section class="features">
    <h3 class="features__title">Dlaczego warto wybrać <span class="highlight">DOM-BUD</span>?</h3>
    <div class="features__grid">

      <div class="features__box">
        <img src="/img/icons/star.svg" alt="Renoma" class="features__icon">
        <h4 class="features__box-title">Renoma</h4>
        <p class="features__box-text">Ponad 25 lat na rynku budowlanym. Nasze doświadczenie doceniły tysiące klientów z całego regionu.</p>
      </div>

      <div class="features__box">
        <img src="/img/icons/shopping.svg" alt="Szeroka oferta" class="features__icon">
        <h4 class="features__box-title">Szeroka oferta</h4>
        <p class="features__box-text">Materiały budowlane, wykończeniowe i akcesoria w konkurencyjnych cenach.</p>
      </div>

      <div class="features__box">
        <img src="/img/icons/handshake.svg" alt="Wsparcie" class="features__icon">
        <h4 class="features__box-title">Wsparcie</h4>
        <p class="features__box-text">Doradztwo techniczne, transport i indywidualne podejście do każdego klienta.</p>
      </div>

    </div>
  </section>

  <section class="brands">
    <h3 class="brands__title">Współpracujemy z najlepszymi producentami</h3>

    <div class="brands__slider">
      <div class="brands__track">

        <?php
        $brandsDir = __DIR__ . '/../../public/img/logos';
        $brandsUrl = '/img/logos';

        $files = glob($brandsDir . '/*.{webp,png,jpg,jpeg,svg}', GLOB_BRACE);
        sort($files);

        foreach ($files as $file) {
          $filename = basename($file);

          $alt = ucwords(
            str_replace(
              ['-', '_'],
              ' ',
              pathinfo($filename, PATHINFO_FILENAME)
            )
          );
        ?>

          <div class="brands__item">
            <img src="<?= $brandsUrl . '/' . $filename ?>" alt="<?= $alt ?>" loading="lazy">
          </div>

        <?php } ?>

      </div>
    </div>
  </section>

  <?php include __DIR__ . '/partials/cta.php'; ?>
  <?php include __DIR__ . '/partials/footer.php'; ?>

  <button id="scrollUp" class="scroll-up">▲</button>

  <script type="module" src="/js/navbar.js"></script>
  <script src="/js/home/brands.js"></script>
  <script type="module" src="/js/scroll-up.js"></script>

</body>

</html>