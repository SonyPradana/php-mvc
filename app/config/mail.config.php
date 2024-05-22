<?php

return [
    'MAIL_DRIVER'       => $_ENV['MAIL_DRIVER'] ?? 'smtp',
    'MAIL_HOST'         => $_ENV['MAIL_HOST'] ?? '127.0.0.1',
    'MAIL_PORT'         => $_ENV['MAIL_PORT'] ?? 2525,
    'MAIL_USERNAME'     => $_ENV['MAIL_USERNAME'] ?? null,
    'MAIL_PASSWORD'     => $_ENV['MAIL_PASSWORD'] ?? null,
    'MAIL_ENCRYPTION'   => $_ENV['MAIL_ENCRYPTION'] ?? null,
    'MAIL_FROM_ADDRESS' => $_ENV['MAIL_FROM_ADDRESS'] ?? 'email@domainname.com',
];
