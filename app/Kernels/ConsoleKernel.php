<?php

declare(strict_types=1);

namespace App\Kernels;

use System\Integrate\Application;
use System\Integrate\Console\Karnel;

class ConsoleKernel extends Karnel
{
    /** @var \Whoops\Run */
    private $run;

    /** @var \Whoops\Handler */
    private $handler;

    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->app->bootedCallback(function () {
            /* @var \Whoops\Handler\PlainTextHandler */
            $this->handler = $this->app->make('error.PlainTextHandler');

            /* @var \Whoops\Run */
            $this->run = $this->app->make('error.handle');
            $this->run
              ->pushHandler($this->handler)
              ->register();
        });
    }
}
