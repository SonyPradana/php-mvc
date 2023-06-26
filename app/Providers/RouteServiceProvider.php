<?php

declare(strict_types=1);

namespace App\Providers;

use App\Middlewares\AppMiddleware;
use System\Integrate\ServiceProvider;
use System\Router\Router;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Router::middleware([
            // middleware
            AppMiddleware::class,
        ])->group(
            fn () => [
                require_once base_path('/routes/web.php'),
                require_once base_path('/routes/api.php'),
            ]
        );
    }
}
