<?php

use App\Exceptions\Handler;
use App\Kernels\ConsoleKernel;
use App\Kernels\HttpKernel;

Dotenv\Dotenv::createImmutable(dirname(__DIR__))->load();

$app = new System\Integrate\Application(dirname(__DIR__));

$app->set(
    System\Integrate\Http\Karnel::class,
    fn() => new HttpKernel($app)
);

$app->set(
    System\Integrate\Console\Karnel::class,
    fn () => new ConsoleKernel($app)
);

$app->set(
    System\Integrate\Exceptions\Handler::class,
    fn () => new Handler($app)
);

return $app;
