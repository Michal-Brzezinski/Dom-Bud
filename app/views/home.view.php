<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DOM-BUD Skład Budowlany</title>
  <link rel="icon" href="/img/dom-bud_logo.png" type="image/webp">
  <link rel="stylesheet" href="/css/navbar.css">
  <link rel="stylesheet" href="/css/footer.css">
  <link rel="stylesheet" href="/css/cta.css">
  <link rel="stylesheet" href="/css/scroll-up.css">
  <link rel="stylesheet" href="/css/style.css">
</head>

<body class="site">

  <!-- Nawigacja -->
  <?php include __DIR__ . '/partials/navbar.php'; ?>

  <!-- Hero -->
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

  <!-- Features -->
  <section class="features">
    <h3 class="features__title">Dlaczego warto wybrać <span class="highlight">DOM-BUD</span>?</h3>
    <div class="features__grid">
      <div class="features__box">
        <h4 class="features__box-title">Renoma</h4>
        <p class="features__box-text">Ponad 25 lat na rynku budowlanym. Nasze doświadczenie doceniły tysiące klientów z całego regionu.</p>
      </div>
      <div class="features__box">
        <h4 class="features__box-title">Szeroka oferta</h4>
        <p class="features__box-text">Materiały budowlane, wykończeniowe i akcesoria w konkurencyjnych cenach.</p>
      </div>
      <div class="features__box">
        <h4 class="features__box-title">Wsparcie</h4>
        <p class="features__box-text">Doradztwo techniczne, transport i indywidualne podejście do każdego klienta.</p>
      </div>
    </div>
  </section>

  <section class="brands">
    <h3 class="brands__title">Współpracujemy z najlepszymi producentami</h3>
    <div class="brands__slider">
      <div class="brands__track">
        <!-- Tylko oryginalne loga - JS zduplikuje je automatycznie -->
        <div class="brands__item">
          <a href="https://www.atlas.com.pl" target="_blank" rel="noopener noreferrer">
            <img src="/img/icons/atlas.png" alt="Atlas">
          </a>
        </div>
        <div class="brands__item">
          <a href="https://www.knauf.pl" target="_blank" rel="noopener noreferrer">
            <img src="/img/icons/knauf.png" alt="Knauf">
          </a>
        </div>
        <div class="brands__item">
          <a href="https://www.cersanit.com" target="_blank" rel="noopener noreferrer">
            <img src="/img/icons/cersanit.png" alt="Cersanit">
          </a>
        </div>
        <div class="brands__item">
          <a href="https://www.baumit.pl" target="_blank" rel="noopener noreferrer">
            <img src="/img/icons/baumit.png" alt="Baumit">
          </a>
        </div>
        <div class="brands__item">
          <a href="https://www.sopro.com" target="_blank" rel="noopener noreferrer">
            <img src="/img/icons/sopro.png" alt="Sopro">
          </a>
        </div>
        <div class="brands__item">
          <a href="https://www.isover.pl" target="_blank" rel="noopener noreferrer">
            <img src="/img/icons/isover.webp" alt="Isover">
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <?php include __DIR__ . '/partials/cta.php'; ?>

  <!-- Stopka -->
  <?php include __DIR__ . '/partials/footer.php'; ?>

  <button id="scrollUp" class="scroll-up">🢁</button>

  <script type="module" src="/js/navbar.js"></script>
  <script src="/js/home/brands.js"></script>
  <script type="module" src="/js/scroll-up.js"></script>


</body>

</html>