<?php

declare(strict_types=1);

use System\Container\Container;
use System\Http\Request;
use System\Http\Response;
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

        if (app()->isDev()) {
            /* @var \Whoops\Handler\PrettyPageHandler */
            $this->handler = $this->app->make('error.PrettyPageHandler');
            $this->handler->setPageTitle('php mvc');

            /* @var \Whoops\Run */
            $this->run = $app->make('error.handle');
            $this->run
              ->pushHandler($this->handler)
              ->register();
        }
    }

    public function handle(Request $request)
    {
        $this->app->set(Request::class, $request);

        $dispatcher = new RouteDispatcher($request, Router::getRoutesRaw());

        $content = $dispatcher->run(
            // found
            fn ($callable, $param) => $this->app->call($callable, $param),
            // not found
            fn ($path) => '404',
            // method not allowed
            fn ($path, $method) => '405'
        );

        $content = $this->call_middleware($content['callable'], $content['params'], $content['middleware']);

        if ($content instanceof Response) {
            return $content;
        }

        if (is_string($content)) {
            return new Response($content);
        }

        if (is_array($content)) {
            return new Response($content);
        }

        throw new Exception('Content must return as respone|string|array');
    }
}
