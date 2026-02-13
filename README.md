# DOM-BUD - Strona Składu Budowlanego

Profesjonalna strona internetowa dla składu materiałów budowlanych DOM-BUD, stworzona w czystym PHP z wykorzystaniem wzorca MVC.

## Opis projektu

DOM-BUD to w pełni funkcjonalna strona internetowa dla składu budowlanego, oferująca:

- **Katalog produktów** - przeglądanie produktów według kategorii z możliwością wyszukiwania i sortowania
- **System paginacji** - wydajna nawigacja przez duże zbiory produktów
- **Formularz kontaktowy** - integracja z PHPMailer do obsługi zapytań klientów
- **Responsywny design** - pełna kompatybilność z urządzeniami mobilnymi
- **Modale produktów** - szczegółowe informacje o produktach w eleganckiej nakładce
- **Optymalizacja wydajności** - WebP, lazy loading, minimalizacja CSS/JS

## Wymagania systemowe

- **PHP** 8.1 lub nowszy
- **Composer** (do zarządzania zależnościami)
- **Apache** z mod_rewrite
- **Rozszerzenia PHP**:
  - mbstring (obsługa polskich znaków)
  - intl (sortowanie polskich znaków)
  - json
  - pdo (opcjonalne, dla przyszłego rozszerzenia)

## Struktura projektu
```
Dom-Bud/
├── app/                        # Backend aplikacji
│   ├── Config/                 # Pliki konfiguracyjne
│   ├── Controllers/            # Kontrolery MVC
│   ├── Core/                   # Rdzeń aplikacji (Router)
│   ├── Repositories/           # Warstwa dostępu do danych
│   ├── Services/               # Logika biznesowa
│   └── Views/                  # Szablony widoków
│       └── partials/           # Komponenty wielokrotnego użytku
├── css/                        # Arkusze stylów
│   ├── base/                   # Style bazowe
│   ├── catalog/                # Style katalogu produktów
│   ├── components/             # Komponenty UI
│   ├── layout/                 # Layouty sekcji
│   └── pages/                  # Style specyficzne dla stron
├── js/                         # Skrypty JavaScript
│   ├── catalog/                # Funkcjonalność katalogu
│   ├── contact/                # Walidacja formularza
│   └── home/                   # Animacje strony głównej
├── img/                        # Zasoby graficzne
│   ├── categories/             # Obrazy kategorii
│   ├── products/               # Zdjęcia produktów
│   ├── logos/                  # Loga partnerów
│   └── icons/                  # Ikony SVG
├── data/                       # Dane aplikacji
│   └── products.json           # Baza produktów
├── fonts/                      # Czcionki niestandardowe
├── vendor/                     # Zależności Composer
├── .htaccess                   # Konfiguracja Apache
├── index.php                   # Punkt wejścia aplikacji
└── .env                        # Zmienne środowiskowe
```

## Instalacja

### 1. Klonowanie repozytorium
```bash
git clone https://github.com/Michal-Brzezinski/dom-bud.git
cd dom-bud
```

### 2. Instalacja zależności
```bash
composer install
```

### 3. Konfiguracja środowiska

Skopiuj plik `.env.example` do `.env` i uzupełnij dane SMTP:
```bash
cp .env.example .env
nano .env
```

Przykładowa konfiguracja `.env`:
```env
# SMTP Configuration
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_SECURE=tls
SMTP_USER=twoj-email@gmail.com
SMTP_PASS=twoje-haslo-aplikacji

# Mail settings
MAIL_FROM=kontakt@dombudtymbark.pl
MAIL_FROM_NAME=DOM-BUD Kontakt
MAIL_TO_1_EMAIL=biuro@dombudtymbark.pl
MAIL_TO_1_NAME=Biuro DOM-BUD
```

### 4. Konfiguracja serwera

#### Opcja A: Lokalny serwer PHP (rozwój)
```bash
php -S localhost:8000
```

Aplikacja będzie dostępna pod adresem `http://localhost:8000`

#### Opcja B: Apache (produkcja)

1. Upewnij się że mod_rewrite jest włączony:
```bash
   sudo a2enmod rewrite
   sudo systemctl restart apache2
```

2. Ustaw document root na katalog główny projektu

3. Upewnij się że `.htaccess` jest w katalogu głównym projektu

## Wdrożenie na hosting

Skopiuj całą zawartość katalogu głónego repozytorium do katalogu hostowanego

## Konfiguracja

### Routing

Trasy definiowane są w `app/routes.php`:
```php
$router->get('', 'HomeController', 'index');
$router->get('o-nas', 'AboutController', 'index');
$router->get('katalog', 'CatalogController', 'index');
$router->get('katalog/{category}', 'CatalogController', 'category');
$router->get('kontakt', 'ContactController', 'showForm');
$router->post('kontakt/send', 'ContactController', 'handle');
```

### Produkty

Produkty zarządzane są przez plik `data/products.json`:
```json
[
  {
    "name": "Cement Portland 25kg",
    "description": "Wysokiej jakości cement budowlany",
    "category": "materialy-konstrukcyjne",
    "image": "img/products/cement.webp"
  }
]
```

**Dostępne kategorie:**
- chemia-budowlana
- instalacje-elektryczne
- instalacje-wodno-kanalizacyjne-i-wentylacyjne
- malowanie-i-wykonczenie
- materialy-konstrukcyjne
- narzedzia
- odziez-i-srodki-bhp
- pokrycia-dachowe
- systemy-docieplen
- systemy-mocowan

## Funkcjonalności

### System katalogowania

- **Kategorie** - 10 kategorii produktów budowlanych
- **Wyszukiwanie** - pełnotekstowe wyszukiwanie w nazwach produktów
- **Sortowanie** - alfabetyczne (A-Z, Z-A) z obsługą polskich znaków
- **Paginacja** - 20 produktów na stronę
- **Modale** - szczegółowy podgląd produktu

### Formularz kontaktowy

- Walidacja po stronie klienta (JavaScript)
- Walidacja po stronie serwera (PHP)
- Wysyłka przez PHPMailer z konfiguracją SMTP
- Zabezpieczenia przed spamem

### Optymalizacja

- **Obrazy WebP** - redukcja rozmiaru o 30-80%
- **Lazy loading** - opóźnione ładowanie obrazów
- **CSS sprites** - optymalizacja ikon
- **Minifikacja** - zminimalizowane CSS/JS (produkcja)
- **Cache headers** - długoterminowe cache'owanie zasobów

## Obsługiwane przeglądarki

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Technologie

### Backend
- PHP 7.4+
- Composer (autoloading PSR-4)
- PHPMailer 6.x (wysyłka e-mail)

### Frontend
- HTML5
- CSS3 (Grid, Flexbox, Custom Properties)
- JavaScript ES6+ (Modules)
- Vanilla JS (bez frameworków)

### Narzędzia deweloperskie
- Git (kontrola wersji)
- VS Code (edytor)
- Apache (serwer HTTP)

## Rozwój

### Uruchomienie w trybie deweloperskim
```bash
# Lokalny serwer PHP:
php -S localhost:8000

# Z wyświetlaniem błędów:
php -d display_errors=1 -S localhost:8000
```

### Dodawanie nowych tras

Edytuj `app/routes.php`:
```php
$router->get('nowa-strona', 'NowyController', 'metoda');
```

### Dodawanie nowych produktów

Edytuj `data/products.json`:
```json
{
  "name": "Nowy Produkt",
  "description": "Opis produktu",
  "category": "kategoria-slug",
  "image": "img/products/plik.webp"
}
```

## Bezpieczeństwo

- **XSS Protection** - wszystkie dane wyjściowe escapowane przez `htmlspecialchars()`
- **CSRF Protection** - może być dodane w przyszłości
- **SQL Injection** - nie dotyczy (brak bazy danych SQL)
- **File Upload** - nie zaimplementowane
- **Environment Variables** - wrażliwe dane w `.env` poza katalogiem publicznym

## Licencja

Ten projekt jest dostępny na licencji `Proprietary License`. Zobacz plik `LICENSE` dla szczegółów.

## Autor

Michał Brzeziński

## Kontakt

W razie pytań lub problemów, otwórz issue na GitHubie.

## Historia zmian

### v1.0.0 (2025-02-12)
- Pierwsze wydanie produkcyjne
- 10 kategorii produktów
- System wyszukiwania i sortowania
- Formularz kontaktowy z PHPMailer
- Pełna responsywność
- Obsługa polskich znaków w sortowaniu