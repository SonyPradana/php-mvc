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
        if (file_exists($cache = $this->app->getApplicationCachePath() . 'route.php')) {
            $routes = (array) require $cache;
            foreach ($routes as $route) {
                Router::addRoutes($route);
            }
        } else {
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

        require_once base_path('/routes/schedule.php');
    }
}
