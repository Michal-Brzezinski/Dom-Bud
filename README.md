# DOM-BUD

## Opis projektu
DOM-BUD to serwis internetowy prezentujący ofertę składu budowlanego, informacje o firmie oraz dane kontaktowe. Projekt został przygotowany w oparciu o nowoczesne standardy HTML, CSS i JavaScript, z naciskiem na modularność kodu, responsywność oraz łatwość utrzymania.

## Funkcjonalności
- **Dynamiczne ładowanie produktów** z pliku JSON przy użyciu Fetch API.
- **Modularny kod JS**:
  - `products.js` koordynuje ładowanie danych i renderowanie.
  - `productCard.js` odpowiada za generowanie kart produktów.
  - `modal.js` obsługuje modal ze szczegółami produktu.
  - `utils.js` zawiera funkcje pomocnicze (escape HTML, fetch, komunikaty).
- **Modularny layout HTML** – wspólne elementy (navbar, footer) ładowane przez `include.js`.
- **Responsywność** – układ dostosowany do różnych rozdzielczości.
- **Estetyczne separatory** między sekcjami dla lepszej czytelności.
- **Mapa Google** osadzona na stronie kontaktowej.
- **Spójny design** – wykorzystanie zmiennych CSS (`--color-bg`, `--color-accent`, itp.) dla łatwej zmiany kolorystyki.

## Technologie
- **HTML5** – semantyczna struktura dokumentów.
- **CSS3** – responsywne layouty, animacje, grid, flexbox.
- **JavaScript (ES6+)** – modularny kod, Fetch API, obsługa zdarzeń.
- **JSON** – dane produktów.
- **Google Maps Embed API** – mapa lokalizacji firmy.

## Jak uruchomić
1. Sklonuj repozytorium lub pobierz paczkę projektu.
2. Umieść pliki na serwerze lokalnym lub w katalogu obsługiwanym przez przeglądarkę.
3. Otwórz `index.php` w przeglądarce.
4. Nawigacja i stopka zostaną automatycznie załadowane dzięki `include.js`.

## Rozwój projektu
- Możliwość rozbudowy katalogu o filtrowanie i sortowanie produktów.
- Integracja formularza kontaktowego z backendem (np. PHP, Node.js).
- Rozszerzenie sekcji „Historia firmy” o interaktywny timeline.
- Dodanie lazy loadingu dla obrazów produktów.

## Licencja
Kod źródłowy projektu DOM-BUD jest udostępniany na licencji MIT (patrz plik LICENSE).  
Projekt korzysta również z biblioteki **PHPMailer** (LGPL/MIT), której licencja znajduje się w katalogu `vendor/PHPMailer/`.

# DO ZROBIENIA

- strony błędów np. 404
- jak przechowywać obrazy do poduktów, żeby nie zajmowało za dużo miejsca

# URUCHOMIENIE NA LOCALHOST PHP: php -S localhost:8000 -t public w katalogu głównym projektu

# Ważne drobiazgi (częste pułapki)

Każdy, kto pobierze repo, musi wykonać:

`composer install`

(wcześniej zainstalowany composer)

Następnie jeżeli używasz lokalnego serwera php, to wejdź do katalogu public:
`cd public` a potem uruchom: `php -S localhost:8000 router.php` (potrzebne tylko dla lokalnego serwera PHP)