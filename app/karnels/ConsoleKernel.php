<?php

declare(strict_types=1);

namespace App\Karnels;

use System\Container\Container;
use System\Integrate\Console\Karnel;
use System\Text\Str;

use function System\Console\style;

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

    public function handle($arguments)
    {
        // handle commad empty
        $baseArgs = $arguments[1] ?? '--help';

        // load register command
        self::$command = include config_path() . 'command.config.php';

        foreach (self::$command ?? [] as $cmd) {
            // matching alias
            $use = $cmd['cmd'];

            $found = is_array($use)
              ? collection($use)->some(fn ($alias) => $this->alias($baseArgs, $alias, $cmd['mode']))
              : $this->alias($baseArgs, $use, $cmd['mode'])
            ;

            if ($found) {
                $className    = $cmd['class'];
                $functionName = $cmd['fn'];

                if (class_exists($className)) {
                    $service = new $className($arguments);
                    if (method_exists($service, $functionName)) {
                        $service->{$functionName}();

                        return $this->exit_code = $service->exit ?? 0;
                    }
                }
            }
        }

        // if command not register
        style('Commad Not Found, run help command')->textRed()->new_lines(2)
            ->push('> ')->textDim()
            ->push('php ')->textYellow()
            ->push('cli ')
            ->push('--help')->textDim()
            ->new_lines()
            ->out()
        ;

        return $this->exit_code = 0;
    }

    private function alias($argument, $alias, $mode): bool
    {
        return 'full' === $mode
          ? $argument === $alias
          : Str::startsWith($argument, $alias);
    }
}
