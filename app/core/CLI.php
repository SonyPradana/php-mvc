<?php

namespace System\Apps;

use CronCommand;
use HelpCommand;
use Helper\String\Str;
use MakerCommand;
use ServeCommand;

class CLI
{
  public static $command = [];

  public function __construct(array $arguments)
  {
    // handle commad empty
    $baseArgs = $arguments[1] ?? '--help';

    // load register command
    self::$command = array_merge(
      // help command
      HelpCommand::$command,
      // make somthink command
      MakerCommand::$command,
      // server command
      ServeCommand::$command,
      // cron
      CronCommand::$command,
      // more command here
    );

    foreach (self::$command as $cmd) {
      // matching alias
      $use = $cmd['cmd'];
      if (is_array($use)) {
        foreach ($use as $cmd_alias) {
          $valid = $this->cekAlias($cmd_alias, $baseArgs, $cmd['mode']);
          if ($valid) {
            break;
          }
        }
      } else {
        $valid = $this->cekAlias($use, $baseArgs, $cmd['mode']);
      }

      if ($valid) {
        $className    = $cmd['class'];
        $functionName = $cmd['fn'];

        if (file_exists(APP_FULLPATH['commands'] . $className . '.php')) {
          $service = new $className($arguments);
          if (method_exists($service, $functionName)) {
            call_user_func([$service, $functionName]);
            return;
          }
        }
      }
    }

    // if command not register
    echo "\e[31mCommad Not Found, run help command\e[0m";
    echo "\n\e[33mPHP\e[0m simpus \e[2m--help\e[0m";
  }

  private function cekAlias(string $alias, string $match, string $mode): bool
  {
    $valid = false;
    if ($mode == 'full') {
      $valid = $alias == $match;
    } else {
      $valid = Str::startWith($alias, $match);
    }

    return $valid;
  }
}
