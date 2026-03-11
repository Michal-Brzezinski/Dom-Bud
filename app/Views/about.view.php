<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DOMBUD - O nas</title>
  <link rel="icon" href="<?= asset('img/dom-bud_logo.webp') ?>" type="image/webp">
  <link rel="stylesheet" href="<?= asset('css/navbar.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/footer.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/cta.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/scroll-up.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
</head>

<body class="site" data-base-url="<?= htmlspecialchars($GLOBALS['baseUrl'] ?? '') ?>">

  <!-- Nawigacja -->
  <?php include __DIR__ . '/partials/navbar.php'; ?>

  <!-- Sekcja O nas -->
  <section class="about">
    <!-- Lewa połowa – zdjęcie -->
    <div class="about__image" loading="lazy"></div>

    <!-- Prawa połowa – tekst -->
    <div class="about__content">
      <h2 class="about__title">Kim jesteśmy?</h2>
      <p>
        DOM-BUD to lokalny skład materiałów budowlanych w Tymbarku, który od ponad 13 lat
        stanowi stały punkt zaopatrzenia dla mieszkańców regionu oraz firm wykonawczych realizujących
        inwestycje w powiecie limanowskim i okolicach. Nasze doświadczenie w branży budowlanej sięga ponad 25 lat, co pozwala nam skutecznie wspierać zarówno klientów indywidualnych, jak i profesjonalne ekipy budowlane na każdym etapie inwestycji.
      </p>
      <p>
        Od początku działalności stawiamy na rzetelność, uczciwe podejście do klienta
        oraz specjalistyczne doradztwo oparte na wieloletnim doświadczeniu.
        Dzięki temu nasi klienci mają pewność sprawnej obsługi, dostępności materiałów
        oraz fachowego wsparcia przy podejmowaniu decyzji zakupowych. Naszą misją jest dostarczanie materiałów budowlanych najwyższej jakości w przystępnych cenach.
      </p>
      <p>
        Specjalizujemy się w kompleksowym zaopatrzeniu budów – od materiałów konstrukcyjnych,
        przez chemię budowlaną, systemy dociepleń, pokrycia dachowe, aż po materiały
        wykończeniowe i akcesoria budowlane. Oferujemy produkty renomowanych producentów,
        stawiając na jakość, trwałość oraz sprawdzone rozwiązania technologiczne.
      </p>
    </div>
  </section>

  <!-- Wartości firmy -->
  <section class="features section">
    <h3 class="features__title">Nasze wartości</h3>
    <div class="features__grid">

      <div class="features__box">
        <img src="<?= asset('img/icons/trust.svg') ?>" alt="Zaufanie" class="features__icon">
        <h4 class="features__box-title">Zaufanie</h4>
        <p class="features__box-text">
          Budujemy długofalowe relacje z klientami, stawiając na uczciwe doradztwo,
          przejrzyste warunki i rzetelną obsługę na każdym etapie współpracy.
        </p>
      </div>

      <div class="features__box">
        <img src="<?= asset('img/icons/quality.svg') ?>" alt="Jakość" class="features__icon">
        <h4 class="features__box-title">Jakość</h4>
        <p class="features__box-text">
          Oferujemy wyłącznie sprawdzone materiały budowlane od renomowanych producentów,
          spełniające aktualne normy i wymagania techniczne.
        </p>
      </div>

      <div class="features__box">
        <img src="<?= asset('img/icons/growth.svg') ?>" alt="Rozwój" class="features__icon">
        <h4 class="features__box-title">Rozwój</h4>
        <p class="features__box-text">
          Stale inwestujemy w nowe technologie i nowoczesne rozwiązania,
          aby oferować materiały odpowiadające aktualnym trendom i potrzebom rynku budowlanego.
        </p>
      </div>

    </div>
  </section>

  <!-- Historia firmy -->
  <section class="list section">
    <h3 class="list__title">Działamy razem dla lepszych rozwiązań!</h3>
    <p class="list__intro">
      Nasze podejście opieramy na <span class="highlight">trzech</span>
      wzajemnie uzupełniających się <span class="highlight">wymiarach</span>:
    </p>
    <div class="list__grid">
      <div class="list__card">
        <span class="list__year"><span class="highlight">D</span>ostępność</span>
        <p>
          Od lat współpracujemy z innymi składami oraz firmami budowlanymi,
          dzięki czemu możemy zapewnić naszym klientom dostęp do szerokiej
          oferty materiałów oraz sprawdzonych producentów.
        </p>
      </div>
      <div class="list__card">
        <span class="list__year"><span class="highlight">D</span>oświadczenie</span>
        <p>Równolegle prowadzimy sklep z materiałami budowlanymi Chem-Bud,
          posiadający trzy oddziały w Nowym Sączu, który działa nieprzerwanie od ponad 25 lat.
          Zdobyte przez lata doświadczenie pozwala nam doskonale rozumieć
          potrzeby zarówno klientów indywidualnych, jak i wykonawców.
        </p>
      </div>
      <div class="list__card">
        <span class="list__year"><span class="highlight">D</span>ojrzałość</span>
        <p>Stawiamy na partnerskie relacje, rzetelność oraz wiedzę,
          którą wykorzystujemy w codziennej pracy.</p>
      </div>
    </div>
    <br><br>
    <p class="list__intro">
      To nasze <span class="highlight">3D</span>, które pozwala patrzeć szerzej, działać skuteczniej i budować trwałe relacje.
    </p>

    <p class="about__cta">
      Zapraszamy do współpracy wszystkich, którzy cenią <strong>solidność</strong>,
      <strong>terminowość</strong> i <strong>profesjonalne podejście</strong> do realizacji inwestycji.
      Niezależnie od tego, czy planujesz budowę domu, modernizację obiektu
      czy drobny remont – w DOM-BUD znajdziesz nie tylko materiały, ale także pełne
      wsparcie i doświadczenie potrzebne do sprawnej realizacji Twojego projektu.
    </p>


  </section>

  <!-- CTA -->
  <?php include __DIR__ . '/partials/cta.php'; ?>

  <!-- Stopka -->
  <?php include __DIR__ . '/partials/footer.php'; ?>

  <button id="scrollUp" class="scroll-up">
    <img src="<?= asset('img/icons/arrow-up.svg') ?>" alt="Scroll up" />
  </button>

  <script type="module" src="<?= asset('js/navbar.js') ?>"></script>
  <script type="module" src="<?= asset('js/scroll-up.js') ?>"></script>

</body>

</html>