<?php

declare(strict_types=1);

namespace App\Kernels;

use System\Integrate\Application;
use System\Integrate\Http\Karnel as Kernel;
use System\Router\RouteDispatcher;
use System\Router\Router;

class HttpKernel extends Kernel
{
    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->app->bootedCallback(function () {
            if ($this->app->isDebugMode() && class_exists(\Whoops\Run::class)) {
                /* @var \Whoops\Handler\PrettyPageHandler */
                $handler = $this->app->make('error.PrettyPageHandler');
                $handler->setPageTitle('php mvc');

                /* @var \Whoops\Run */
                $run = $this->app->make('error.handle');
                $run
                  ->pushHandler($handler)
                  ->register();
            }
        });
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
