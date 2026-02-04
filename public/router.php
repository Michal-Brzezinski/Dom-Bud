<?php
// Jeśli żądany plik istnieje fizycznie — serwuj go normalnie
if (php_sapi_name() === 'cli-server') {
    $path = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file($path)) {
        return false;
    }
}

// W przeciwnym razie — przekazuj wszystko do index.php
require __DIR__ . '/index.php';
