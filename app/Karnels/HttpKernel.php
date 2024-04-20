<?php

declare(strict_types=1);

namespace App\Karnels;

use System\Container\Container;
use System\Integrate\Http\Karnel;
use System\Router\RouteDispatcher;
use System\Router\Router;

class HttpKernel extends Karnel
{
    /** @var \Whoops\Run */
    private $run;
    /** @var \Whoops\Handler */
    private $handler;

    public function __construct(Container $app)
    {
        parent::__construct($app);

        /* @var \Whoops\Handler\CallbackHandler */
        $http_handler = $this->app->make('error.CallbackHandler');
        /* @var \Whoops\Run */
        $this->run = $app->make('error.handle');

        if (app()->isDev()) {
            /* @var \Whoops\Handler\PrettyPageHandler */
            $this->handler = $this->app->make('error.PrettyPageHandler');
            $this->handler->setPageTitle('php mvc');
            $this->run->pushHandler($this->handler);
        }

        $this->run->pushHandler($http_handler);
        $this->run->register();
    }

    protected function dispatcher($request): array
    {
        $dispatcher = new RouteDispatcher($request, Router::getRoutesRaw());

        $content = $dispatcher->run(
            // found
            fn ($callable, $param) => $this->app->call($callable, $param),
            // not found
            fn ($path) => view('pages/404', [
                'path'    => $path,
                'headers' => ['status' => 404],
            ]),
            // method not allowed
            fn ($path, $method) => view('pages/405', [
                'path'    => $path,
                'method'  => $method,
                'headers' => ['status' => 405],
            ])
        );

        return [
            'callable'   => $content['callable'],
            'parameters' => $content['params'],
            'middleware' => $content['middleware'],
        ];
    }
}
