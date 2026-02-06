<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DOMBUD - Kontakt</title>
  <link rel="icon" href="/img/dom-bud_logo.png" type="image/webp">
  <link rel="stylesheet" href="/css/navbar.css">
  <link rel="stylesheet" href="/css/footer.css">
  <link rel="stylesheet" href="/css/cta.css">
  <link rel="stylesheet" href="/css/style.css">
</head>

<body class="site">

  <?php include __DIR__ . '/partials/navbar.php'; ?>

  <section class="contact section">
    <h2 class="contact__title">Skontaktuj się z nami</h2>

    <div class="contact__grid">

      <div class="contact__form">

        <?php if (isset($_GET['status'])): ?>

          <?php
          $translated = $_GET['status'] === 'ok'
            ? "Wiadomość została wysłana."
            : "Wystąpił błąd podczas wysyłania wiadomości.";
          ?>

          <div class="form__message <?= $_GET['status'] === 'ok' ? 'success' : 'error' ?>">
            <?= $translated ?>
          </div>

        <?php endif; ?>

        <form action="/kontakt/send" method="POST">
          <label for="name">Imię i nazwisko</label>
          <input type="text" id="name" name="name" required>

          <label for="email">Email</label>
          <input type="email" id="email" name="email" required>

          <label for="message">Wiadomość</label>
          <textarea id="message" name="message" rows="5" required></textarea>

          <button type="submit" class="cta__button">Wyślij</button>
        </form>
      </div>

      <!-- Dane kontaktowe -->
      <div class="contact__info">
        <h3>Dane kontaktowe</h3>

        <div class="contact__item">
          <svg xmlns="http://www.w3.org/2000/svg" class="contact__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 5a2 2 0 012-2h2.28a2 2 0 011.94 1.515l.72 2.88a2 2 0 01-.45 1.86l-1.27 1.27a16.017 16.017 0 006.586 6.586l1.27-1.27a2 2 0 011.86-.45l2.88.72A2 2 0 0121 16.72V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
          </svg>
          <span class="contact__label">Tel:</span>
          <span class="contact__value">+48 668 979 045</span>
        </div>

        <div class="contact__item">
          <svg xmlns="http://www.w3.org/2000/svg" class="contact__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 8l9 6 9-6M4 6h16a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2z" />
          </svg>
          <span class="contact__label">Email:</span>
          <span class="contact__value">info@dombudtymbark.pl</span>
        </div>

        <div class="contact__item">
          <svg xmlns="http://www.w3.org/2000/svg" class="contact__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 2C8.134 2 5 5.134 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.866-3.134-7-7-7z" />
            <circle cx="12" cy="9" r="2.5" />
          </svg>
          <span class="contact__label">Adres:</span>
          <span class="contact__value">Tymbark 736, 34-650 Tymbark</span>
        </div>

        <hr class="contact__separator">

        <h3>Dane firmowe</h3>
        <p><strong>Nazwa pełna:</strong> Firma Handlowo Usługowa Dom-Bud Piotr Tokarczyk, Krzysztof Tokarczyk Spółka Cywilna</p>
        <p><strong>Forma prawna:</strong> Spółka Cywilna</p>
        <p><strong>Adres siedziby:</strong> ul. Partyzantów 10, 33-340 Stary Sącz</p>
        <p><strong>NIP:</strong> 734 366 15 26</p>
        <p><strong>REGON:</strong> 542775632</p>
      </div>
  </section>

  <section class="map section">
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2560.123456789!2d20.634!3d49.563!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4715f123456789%3A0xabcdef123456789!2sTymbark%20736%2C%2034-650%20Tymbark!5e0!3m2!1spl!2spl!4v1700000000000"
      width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy">
    </iframe>
  </section>

  <?php include __DIR__ . '/partials/footer.php'; ?>

  <script src="/js/contact-validation.js"></script>
  <script type="module" src="/js/navbar.js"></script>
</body>

</html>