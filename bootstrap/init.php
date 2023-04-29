<?php

use App\Karnels\ConsoleKernel;
use App\Karnels\HttpKernel;

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

return $app;
