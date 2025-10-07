<?php

return [
    'db.default'     => $_ENV['DB_CONNECTION'] ?? 'mysql',
    'db.connections' => [
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => $_ENV['DB_HOST'] ?? 'localhost',
            'username'  => $_ENV['DB_USER'] ?? 'root',
            'password'  => $_ENV['DB_PASS'] ?? '',
            'database'  => $_ENV['DB_NAME'] ?? '',
            'port'      => (int) ($_ENV['DB_PORT'] ?? 3306),
            'chartset'  => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
            'options'   => [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ],
        ],
        'mariadb' => [
            'driver'    => 'mariadb',
            'host'      => $_ENV['DB_HOST'] ?? 'localhost',
            'username'  => $_ENV['DB_USER'] ?? 'root',
            'password'  => $_ENV['DB_PASS'] ?? '',
            'database'  => $_ENV['DB_NAME'] ?? '',
            'port'      => (int) ($_ENV['DB_PORT'] ?? 3306),
            'chartset'  => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
            'options'   => [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ],
        ],
        'pgsql' => [
            'driver'   => 'pgsql',
            'host'     => $_ENV['DB_HOST'] ?? 'localhost',
            'username' => $_ENV['DB_USER'] ?? 'root',
            'password' => $_ENV['DB_PASS'] ?? '',
            'database' => $_ENV['DB_NAME'] ?? '',
            'port'     => (int) ($_ENV['DB_PORT'] ?? 5432),
            'charset'  => $_ENV['DB_CHARSET'] ?? 'utf8',
            'options'  => [
                PDO::ATTR_CASE               => PDO::CASE_NATURAL,
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_ORACLE_NULLS       => PDO::NULL_NATURAL,
                PDO::ATTR_STRINGIFY_FETCHES  => false,
            ],
        ],
        'sqlite' => [
            'driver'   => 'sqlite',
            'database' => DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . ($_ENV['DB_DATABASE'] ?? 'database.sqlite'),
            'options'  => [
                PDO::ATTR_CASE               => PDO::CASE_NATURAL,
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_ORACLE_NULLS       => PDO::NULL_NATURAL,
                PDO::ATTR_STRINGIFY_FETCHES  => false,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ],
        ],
    ],
];
