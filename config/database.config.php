<?php

return [
    'db.default'     => 'mysql',
    'db.connections' => [
        'mysql' => [
            'host'          => $_ENV['DB_HOST'] ?? 'localhost',
            'user'          => $_ENV['DB_USER'] ?? 'root',
            'password'      => $_ENV['DB_PASS'] ?? '',
            'database_name' => $_ENV['DB_NAME'] ?? '',
        ],
    ],
];
