<nav class="navbar">

  <!-- LOGO -->
  <a href="<?= url() ?>" class="navbar__logo">
    <span class="navbar__logo-text">DOM-BUD</span>
    <img src="<?= asset('img/dom-bud_logo.webp') ?>" alt="Logo Dom-Bud" class="navbar__logo-img">
  </a>

  <!-- STATUS (desktop ≥1280px) -->
  <div class="navbar-status desktop-only" id="status-trigger">
    <span class="status-dot"></span>
    <span id="store-status">Sprawdzanie...</span>
  </div>

  <!-- HAMBURGER -->
  <button class="navbar__toggle" aria-label="Menu">☰</button>

  <!-- MENU -->
  <ul class="navbar__menu">
    <li><a href="<?= url() ?>" class="navbar__link">Strona główna</a></li>
    <li><a href="<?= url('katalog') ?>" class="navbar__link">Oferta</a></li>
    <li><a href="<?= url('o-nas') ?>" class="navbar__link">O nas</a></li>
    <li><a href="<?= url('kontakt') ?>" class="navbar__link">Kontakt</a></li>
  </ul>

  <!-- SOCIAL -->
  <div class="navbar__social">

    <a href="https://www.google.com/maps/place/Dom-Bud+sk%C5%82ad+materia%C5%82%C3%B3w+budowlanych/"
      target="_blank" class="social-link" aria-label="Lokalizacja Dom-Bud">
      <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24">
        <path d="M12 2C8.14 2 5 5.14 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.86-3.14-7-7-7zm0 
                 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z" />
      </svg>
    </a>

    <a href="https://www.facebook.com/people/Dom-Bud-Materia%C5%82y-Budowlane-Tymbark/61587714012828/"
      target="_blank" class="social-link" aria-label="Facebook">
      <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24">
        <path d="M22 12c0-5.522-4.477-10-10-10S2 6.478 2 12c0 4.991 
        3.657 9.128 8.438 9.878v-6.988H7.898v-2.89h2.54V9.797c0-2.507 
        1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 
        0-1.63.771-1.63 1.562v1.875h2.773l-.443 2.89h-2.33v6.988C18.343 
        21.128 22 16.991 22 12z" />
      </svg>
    </a>

    <a href="https://www.instagram.com/p/DQSWnZsjOR5/"
      target="_blank" class="social-link" aria-label="Instagram">
      <svg xmlns="http://www.w3.org/2000/svg" class="icon" viewBox="0 0 24 24">
        <path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm0 2a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7zm5 3a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6zm4.5-2a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
      </svg>
    </a>

  </div>

</nav>

<!-- PANEL BOCZNY -->
<div id="store-panel-overlay"></div>

<aside id="store-panel">
  <button id="panel-close">×</button>

  <h2 id="panel-store-name"></h2>

  <div class="panel-status">
    <span class="status-dot"></span>
    <span id="panel-status-text"></span>
  </div>

  <div class="panel-section">
    <h3>Adres</h3>
    <p id="panel-address"></p>
  </div>

  <div class="panel-section">
    <h3>Telefon</h3>
    <p id="panel-phone"></p>
  </div>

  <div class="panel-section">
    <h3>Godziny otwarcia</h3>
    <ul id="panel-hours"></ul>
  </div>

  <a id="panel-offer-btn" class="panel-offer-btn">Przejdź do oferty</a>
</aside>