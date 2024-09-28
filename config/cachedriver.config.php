<?php

return [
    'CACHE_STORAGE' => $_ENV['CACHE_STORAGE'] ?? 'file',

    // redis driver
    'REDIS_HOST' => $_ENV['REDIS_HOST'] ?? '127.0.0.1',
    'REDIS_PASS' => $_ENV['REDIS_PASS'] ?? '',
    'REDIS_PORT' => $_ENV['REDIS_PORT'] ?? 6379,

    // memcahe
    'MEMCACHED_HOST' => $_ENV['MEMCACHED_HOST'] ?? '127.0.0.1',
    'MEMCACHED_PASS' => $_ENV['MEMCACHED_PASS'] ?? '',
    'MEMCACHED_PORT' => $_ENV['MEMCACHED_PORT'] ?? 6379,
];
