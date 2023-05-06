<?php

return [
  'BASEURL'     => dirname(__DIR__, 2),
  'time_zone'   => 'Asia/Jakarta',
  'ENVIRONMENT' => $_ENV['ENVIRONMENT'] ?? 'dev',

  'MODEL_PATH'        => DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR,
  'CONTROLLER_PATH'   => DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR,
  'SERVICES_PATH'     => DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'services' . DIRECTORY_SEPARATOR,
  'VIEW_PATH'         => DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR,
  'COMPONENT_PATH'    => DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR,
  'COMMNAD_PATH'      => DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'commands' . DIRECTORY_SEPARATOR,
  'CACHE_PATH'        => DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR,
  'CONFIG'            => DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR,
  'MIDDLEWARE'        => DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'middlewares' . DIRECTORY_SEPARATOR,
  'SERVICE_PROVIDER'  => DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'providers' . DIRECTORY_SEPARATOR,

  'PROVIDERS' => [
        App\Providers\AppServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\DatabaseServiceProvider::class,
  ],
];
