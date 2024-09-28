<?php

return [
    'DB_HOST' => $_ENV['DB_HOST'] ?? 'localhost',
    'DB_USER' => $_ENV['DB_USER'] ?? 'root',
    'DB_PASS' => $_ENV['DB_PASS'] ?? '',
    'DB_NAME' => $_ENV['DB_NAME'] ?? '',
];
