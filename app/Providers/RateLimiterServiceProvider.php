<?php

declare(strict_types=1);

namespace App\Providers;

use System\Cache\CacheManager;
use System\Integrate\Http\Middleware\ThrottleMiddleware;
use System\Integrate\ServiceProvider;
use System\RateLimiter\RateLimiterFactory;

class RateLimiterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /** @var CacheManager */
        $cache   = $this->app->get('cache');
        $rate    = new RateLimiterFactory($cache);
        $thottle = new ThrottleMiddleware($rate->createFixedWindow(60, 60));

        $this->app->set(ThrottleMiddleware::class, fn () => $thottle);
    }
}
