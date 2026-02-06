<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DOM-BUD Skład Budowlany</title>
  <link rel="icon" href="/img/dom-bud_logo.png" type="image/webp">
  <link rel="stylesheet" href="/css/navbar.css">
  <link rel="stylesheet" href="/css/footer.css">
  <link rel="stylesheet" href="/css/style.css">
</head>

<body class="site">

  <!-- Nawigacja -->
  <?php include __DIR__ . '/partials/navbar.php'; ?>

  <!-- Hero -->
  <section class="hero">
    <div class="hero__content">
      <h2 class="hero__title">DOM-BUD</h2>
      <h3 class="hero__subtitle">Twój ulubiony skład budowlany</h3>
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
        <p class="features__box-text">Ponad 20 lat na rynku budowlanym — setki zadowolonych klientów.</p>
      </div>
      <div class="features__box">
        <h4 class="features__box-title">Szeroka oferta</h4>
        <p class="features__box-text">Materiały budowlane, wykończeniowe i akcesoria w konkurencyjnych cenach.</p>
      </div>
      <div class="features__box">
        <h4 class="features__box-title">Wsparcie</h4>
        <p class="features__box-text">Doradztwo techniczne, transport i indywidualne podejście do klienta.</p>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <?php include __DIR__ . '/partials/cta.php'; ?>

  <!-- Stopka -->
  <?php include __DIR__ . '/partials/footer.php'; ?>

  <script type="module" src="/js/navbar.js"></script>

</body>

</html>