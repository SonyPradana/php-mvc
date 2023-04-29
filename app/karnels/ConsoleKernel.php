<?php

declare(strict_types=1);

namespace App\Karnels;

use System\Container\Container;
use System\Integrate\Console\Karnel;
use System\Text\Str;

class ConsoleKernel extends Karnel
{
    public static $command = [];

    public function __construct(Container $app)
    {
        parent::__construct($app);
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

                if (file_exists(commands_path() . $className . '.php')) {
                    $service = new $className($arguments);
                    if (method_exists($service, $functionName)) {
                        call_user_func([$service, $functionName]);

                        return $this->exit_code = $service->exit ?? 0;
                    }
                }
            }
        }

        // if command not register
        echo "\e[31mCommad Not Found, run help command\e[0m";
        echo "\n\e[33mPHP\e[0m Savanna \e[2m--help\e[0m";

        return $this->exit_code = 0;
    }

    private function alias($argument, $alias, $mode): bool
    {
        return 'full' === $mode
          ? $argument === $alias
          : Str::startsWith($argument, $alias);
    }
}
