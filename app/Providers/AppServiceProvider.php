<?php

declare(strict_types=1);

namespace App\Providers;

use System\Integrate\Http\Exception\HttpException;
use System\Integrate\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // error handle
        $this->app->set('error.handle', fn () => new \Whoops\Run());
        $this->app->set('error.PrettyPageHandler', fn () => new \Whoops\Handler\PrettyPageHandler());
        $this->app->set('error.PlainTextHandler', fn () => new \Whoops\Handler\PlainTextHandler());
        $this->app->set('error.CallbackHandler', fn () => new \Whoops\Handler\CallbackHandler(static function ($exception, $inspector, $run) {
            if ($exception instanceof HttpException) {
                $response = view('pages/503');
                $response->headers->add($exception->getHeaders());
                $response->setResponeCode($exception->getStatusCode());
                $response->send();

                exit;
            }
        }));
    }
}
