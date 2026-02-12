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
