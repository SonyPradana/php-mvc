<?php

namespace App\Commands;

use App\Karnels\ConsoleKernel;
use System\Integrate\Console\HelpCommand as ConsoleHelpCommand;

class HelpCommand extends ConsoleHelpCommand
{
    public static array $command = [
        [
          'cmd'       => ['-h', '--help'],
          'fn'        => [self::class, 'main'],
        ], [
          'cmd'       => '--list',
          'fn'        => [self::class, 'commandList'],
        ], [
          'cmd'       => 'help',
          'fn'        => [self::class, 'commandhelp'],
        ],
    ];

    protected string $banner =
'   _____ ____ _ _   __ ____ _ ____   ____   ____ _
  / ___// __ `/| | / // __ `// __ \ / __ \ / __ `/
 (__  )/ /_/ / | |/ // /_/ // / / // / / // /_/ /
/____/ \__,_/  |___/ \__,_//_/ /_//_/ /_/ \__,_/  ';

    public function __construct($argv, $default_option = [])
    {
        parent::__construct($argv, $default_option);
        $this->commands = ConsoleKernel::$command;
    }
}
