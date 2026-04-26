<?php

return [
    // SMTP
    'smtp_host'   => getenv('SMTP_HOST'),
    'smtp_port'   => getenv('SMTP_PORT'),
    'smtp_secure' => getenv('SMTP_SECURE'),
    'smtp_user'   => getenv('SMTP_USER'),
    'smtp_pass'   => getenv('SMTP_PASS'),
    'mail_from'   => getenv('MAIL_FROM'),
    'mail_from_name' => getenv('MAIL_FROM_NAME'),
    'mail_to'     => [
        ['email' => getenv('MAIL_TO1'), 'name' => getenv('MAIL_TO1_NAME')],
    ],

    // DB
    'db' => [
        'driver'  => getenv('DB_DRIVER') ?: 'mysql',
        'host'    => getenv('DB_HOST') ?: '127.0.0.1',
        'port'    => getenv('DB_PORT') ?: '3306',
        'name'    => getenv('DB_NAME') ?: '',
        'user'    => getenv('DB_USER') ?: '',
        'pass'    => getenv('DB_PASS') ?: '',
        'charset' => getenv('DB_CHARSET') ?: 'utf8mb4',
    ]
];


// !! WERSJA DLA HOSTINGU:
//<?php
//
// return [
//     // SMTP
//     'smtp_host'   => getenv('SMTP_HOST'),
//     'smtp_port'   => getenv('SMTP_PORT'),
//     'smtp_secure' => getenv('SMTP_SECURE'),
//     'smtp_user'   => getenv('SMTP_USER'),
//     'smtp_pass'   => getenv('SMTP_PASS'),
//     'mail_from'   => getenv('MAIL_FROM'),
//     'mail_from_name' => getenv('MAIL_FROM_NAME'),
//     'mail_to'     => [
//         ['email' => getenv('MAIL_TO1'), 'name' => getenv('MAIL_TO1_NAME')],
//     ],

//     // DB
//     'db' => [
//         'driver'  => 'mysql',
//         'name'    => $_ENV['DB_NAME'] ?? '',
//         'user'    => $_ENV['DB_USER'] ?? '',
//         'pass'    => $_ENV['DB_PASS'] ?? '',
//         'charset' => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
//     ]
// ];
