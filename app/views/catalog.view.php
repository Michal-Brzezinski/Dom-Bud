<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Katalog produktów - Dom-Bud</title>
  <link rel="icon" href="/img/dom-bud_logo.webp" type="image/webp">
  <link rel="stylesheet" href="/css/navbar.css">
  <link rel="stylesheet" href="/css/footer.css">
  <link rel="stylesheet" href="/css/style.css">
</head>

<body class="site">

  <!-- Nawigacja -->
  <div id="navbar-placeholder"></div>

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
  <section class="cta">
    <h3 class="cta__title">Masz pytania?</h3>
    <p class="cta__text">Skontaktuj się z nami! Chętnie doradzimy i przygotujemy odpowiednią ofertę.</p>
    <a href="/kontakt" class="cta__button">Przejdź do kontaktu</a>
  </section>

  <!-- Stopka -->
  <div id="footer-placeholder"></div>

  <script src="/js/include.js"></script>
  <script type="module" src="/js/catalog/products.js"></script>
</body>

</html>