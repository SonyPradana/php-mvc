<?php

declare(strict_types=1);

namespace App\Karnels;

use System\Container\Container;
use System\Integrate\Console\Karnel;
use System\Integrate\ValueObjects\CommadMap;

class ConsoleKernel extends Karnel
{
    public static $command = [];

    /** @var \Whoops\Run */
    private $run;

    /** @var \Whoops\Handler */
    private $handler;

    public function __construct(Container $app)
    {
        parent::__construct($app);

        /* @var \Whoops\Handler\PlainTextHandler */
        $this->handler = $this->app->make('error.PlainTextHandler');

        /* @var \Whoops\Run */
        $this->run = $app->make('error.handle');
        $this->run
          ->pushHandler($this->handler)
          ->register();
    }

    /** {@inheritDoc} */
    protected function commands()
    {
        $commands = static::$command = include config_path() . 'command.config.php';

        /** @var CommandMap[] */
        $maps = [];
        foreach ($commands as $command) {
            $maps[] = new CommadMap($command);
        }

        return $maps;
    }
}
