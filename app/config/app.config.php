<?php

return [
    'BASEURL'           => $_ENV['BASEURL'] ?? 'http://localhost',
    'time_zone'         => 'Asia/Jakarta',
    'APP_KEY'           => $_ENV['APP_KEY'] ?? '',
    'ENVIRONMENT'       => $_ENV['ENVIRONMENT'] ?? $_ENV['APP_ENV'] ?? 'dev',
    'APP_DEBUG'         => $_ENV['APP_DEBUG'],

    'BCRYPT_ROUNDS'     => $_ENV['BCRYPT_ROUNDS'] ?? 12,
    'CONFIG_STORAGE'    => $_ENV['file'] ?? 'file',

    'COMMNAD_PATH'          => DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Commands' . DIRECTORY_SEPARATOR,
    'CONTROLLER_PATH'       => DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR,
    'MODEL_PATH'            => DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR,
    'MIDDLEWARE'            => DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Middlewares' . DIRECTORY_SEPARATOR,
    'SERVICE_PROVIDER'      => DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Providers' . DIRECTORY_SEPARATOR,
    'CONFIG'                => DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR,
    'SERVICES_PATH'         => DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'services' . DIRECTORY_SEPARATOR,
    'VIEW_PATH'             => DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR,
    'COMPONENT_PATH'        => DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR,
    'STORAGE_PATH'          => DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR,
    'CACHE_PATH'            => DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR,
    'CACHE_VIEW_PATH'       => DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR,
    'PUBLIC_PATH'           => DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR,
    'MIGRATION_PATH'        => DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR,
    'SEEDER_PATH'           => DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'seeders' . DIRECTORY_SEPARATOR,

    'PROVIDERS'         => [
        App\Providers\AppServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\DatabaseServiceProvider::class,
        App\Providers\ViewServiceProvider::class,
        App\Providers\CacheServiceProvider::class,
    ],
];
