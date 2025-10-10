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

        $this->app->set(RateLimiterFactory::class, fn () => $rate);
        $this->app->set(ThrottleMiddleware::class, fn () => new ThrottleMiddleware(
            limiter: $rate->createFixedWindow(
                limit: 3,
                windowSeconds: 60
            ))
        );
    }
}
