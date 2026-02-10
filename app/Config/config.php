<?php

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
