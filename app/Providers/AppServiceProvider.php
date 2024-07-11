<?php

declare(strict_types=1);

namespace App\Providers;

use App\Commands\Cron\Log;
use System\Cron\Schedule;
use System\Integrate\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // error handle
        $this->app->set('error.handle', fn () => new \Whoops\Run());
        $this->app->set('error.PrettyPageHandler', fn () => new \Whoops\Handler\PrettyPageHandler());
        $this->app->set('error.PlainTextHandler', fn () => new \Whoops\Handler\PlainTextHandler());

        // register schedule to containel
        $this->app->set('cron.log', fn (): Log => new Log());
        $this->app->set('schedule', fn (): Schedule => new Schedule(now()->timestamp, $this->app['cron.log']));
    }
}
