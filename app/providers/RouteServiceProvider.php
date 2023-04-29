<?php

declare(strict_types=1);

use System\Integrate\ServiceProvider;
use System\Router\Router;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Router::middleware([
            // middleware
        ])->group(
            fn () => [
                require base_path('/routes/web.php'),
            ]
        );
    }
}
