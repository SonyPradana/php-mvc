<?php

namespace App\Commands;

use System\Integrate\Console\HelpCommand as ConsoleHelpCommand;

class HelpCommand extends ConsoleHelpCommand
{
    protected string $banner =
        '   _____ ____ _ _   __ ____ _ ____   ____   ____ _
  / ___// __ `/| | / // __ `// __ \ / __ \ / __ `/
 (__  )/ /_/ / | |/ // /_/ // / / // / / // /_/ /
/____/ \__,_/  |___/ \__,_//_/ /_//_/ /_/ \__,_/  ';
}
