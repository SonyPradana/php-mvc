<?php

declare(strict_types=1);

namespace App\Kernels;

use System\Integrate\Application;
use System\Integrate\Console\Karnel as Kernel;

class ConsoleKernel extends Kernel
{
    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->app->bootedCallback(function () {
              if (class_exists(\Whoops\Run::class)) {
                 /* @var \Whoops\Handler\PlainTextHandler */
                 $handler = $this->app->make('error.PlainTextHandler');

                 /* @var \Whoops\Run */
                 $run = $this->app->make('error.handle');
                 $run
                   ->pushHandler($handler)
                   ->register();
              }
        });
    }
}
