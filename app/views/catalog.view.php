<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DOMBUD - Katalog produktów</title>
  <link rel="icon" href="/img/dom-bud_logo.png" type="image/webp">
  <link rel="stylesheet" href="/css/navbar.css">
  <link rel="stylesheet" href="/css/footer.css">
  <link rel="stylesheet" href="/css/style.css">
</head>

<body class="site">

  <!-- Nawigacja -->
  <?php include __DIR__ . '/partials/navbar.php'; ?>

  <!-- Nagłówek katalogu -->
  <section class="catalog-header">
    <h2 class="catalog-header__title">Katalog produktów</h2>
    <p class="catalog-header__text">
      Oferujemy szeroki wybór materiałów budowlanych najwyższej jakości.
      Poniżej znajdziesz przykładowe produkty dostępne w naszej ofercie.
    </p>
  </section>

  <!-- Grid kart produktów -->
  <section class="products">
    <div class="products__grid">
      <!-- Produkty będą załadowane dynamicznie przez JavaScript -->
    </div>
  </section>

  <!-- CTA -->
  <?php include __DIR__ . '/partials/cta.php'; ?>

  <!-- Stopka -->
  <?php include __DIR__ . '/partials/footer.php'; ?>


  <script type="module" src="/js/catalog/products.js"></script>
  <script type="module" src="/js/navbar.js"></script>
</body>

</html>