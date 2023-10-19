<?php

return array_merge(
    App\Commands\HelpCommand::$command,
    App\Commands\CronCommand::$command,
    System\Integrate\Console\MakeCommand::$command,
    System\Integrate\Console\ServeCommand::$command,
    System\Integrate\Console\RouteCommand::$command,
    System\Integrate\Console\MigrationCommand::$command,
    System\Integrate\Console\SeedCommand::$command,
    // more command here
);
