<?php
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

loadEnv(__DIR__ . '/.env');

return [
    'smtp_host'   => getenv('SMTP_HOST'),
    'smtp_port'   => getenv('SMTP_PORT'),
    'smtp_secure' => getenv('SMTP_SECURE'),
    'smtp_user'   => getenv('SMTP_USER'),
    'smtp_pass'   => getenv('SMTP_PASS'),
    'mail_from'   => getenv('MAIL_FROM'),
    'mail_from_name' => getenv('MAIL_FROM_NAME'),
    'mail_to'     => [
        ['email' => getenv('MAIL_TO1'), 'name' => getenv('MAIL_TO1_NAME')],
    ]
];
