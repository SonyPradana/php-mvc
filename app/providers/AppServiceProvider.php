<?php

declare(strict_types=1);

use System\Integrate\ServiceProvider;
use System\Router\Router;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // error handle
        $this->app->set('error.handle', fn () => new \Whoops\Run());
        $this->app->set('error.PrettyPageHandler', fn () => new \Whoops\Handler\PrettyPageHandler());
        $this->app->set('error.PlainTextHandler', fn () => new \Whoops\Handler\PlainTextHandler());
    }
}
