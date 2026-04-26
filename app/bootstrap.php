<?php

// Ładowanie .env
function loadEnv($path)
{
    if (!file_exists($path)) return;
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        putenv(trim($name) . '=' . trim($value));
    }
}

loadEnv(__DIR__ . '/../.env');

// Ładowanie configu
$config = require __DIR__ . '/Config/config.php';

// Ładowanie helperów
require __DIR__ . '/helpers.php';

// ======================================
// Ścieżka do katalogu głównego aplikacji 
// ======================================
define('ROOT_PATH', dirname(__DIR__));


// Wykrycie bazowego URL aplikacji
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$baseUrl = rtrim(dirname($scriptName), '/');
if ($baseUrl === '\\') {
    $baseUrl = '';
}

// WAŻNE: Udostępnij $baseUrl globalnie dla widoków
$GLOBALS['baseUrl'] = $baseUrl;

// Globalna funkcja pomocnicza do generowania URL-i
function url(string $path = ''): string
{
    global $baseUrl;
    $path = ltrim($path, '/');

    // Jeśli nie ma ścieżki, zwróć baseUrl lub '/'
    if ($path === '') {
        return $baseUrl ?: '/';
    }

    return $baseUrl . '/' . $path;
}

// Funkcja pomocnicza do assetów (css, js, img)
function asset(string $path): string
{
    return url($path);
}

session_start();


// DLA HOSTINGU TAKA WERSJA:
// <?php

// // Ładowanie .env
// function loadEnv($path)
// {
//     if (!file_exists($path)) return;

//     $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

//     foreach ($lines as $line) {
//         if (strpos(trim($line), '#') === 0) continue;

//         list($name, $value) = explode('=', $line, 2);

//         $name  = trim($name);
//         $value = trim($value);

//         putenv("$name=$value");
//         $_ENV[$name]    = $value;
//         $_SERVER[$name] = $value;
//     }
// }

// loadEnv(__DIR__ . '/../.env');

// $config = require __DIR__ . '/Config/config.php';


// loadEnv(__DIR__ . '/../.env');

// // Ładowanie configu
// $config = require __DIR__ . '/Config/config.php';

// // Ładowanie helperów
// require __DIR__ . '/helpers.php';

// // ======================================
// // Ścieżka do katalogu głównego aplikacji 
// // ======================================
// define('ROOT_PATH', dirname(__DIR__));


// // Wykrycie bazowego URL aplikacji
// $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
// $baseUrl = rtrim(dirname($scriptName), '/');
// if ($baseUrl === '\\') {
//     $baseUrl = '';
// }

// // WAŻNE: Udostępnij $baseUrl globalnie dla widoków
// $GLOBALS['baseUrl'] = $baseUrl;

// // Globalna funkcja pomocnicza do generowania URL-i
// function url(string $path = ''): string
// {
//     global $baseUrl;
//     $path = ltrim($path, '/');

//     // Jeśli nie ma ścieżki, zwróć baseUrl lub '/'
//     if ($path === '') {
//         return $baseUrl ?: '/';
//     }

//     return $baseUrl . '/' . $path;
// }

// // Funkcja pomocnicza do assetów (css, js, img)
// function asset(string $path): string
// {
//     return url($path);
// }

// session_start();
