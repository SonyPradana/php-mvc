<?php

return [
    'commands' => [
        App\Commands\HelpCommand::$command,
        App\Commands\CronCommand::$command,
        System\Integrate\Console\MakeCommand::$command,
        System\Integrate\Console\ServeCommand::$command,
        System\Integrate\Console\RouteCommand::$command,
        System\Integrate\Console\MigrationCommand::$command,
        System\Integrate\Console\SeedCommand::$command,
        System\Integrate\Console\ViewCommand::$command,
        System\Integrate\Console\MaintenanceCommand::$command,
        System\Integrate\Console\ConfigCommand::$command,
        System\Integrate\Console\PackageDiscoveryCommand::$command,
        System\Integrate\Console\ClearCacheCommand::$command,
        // more command here
    ],
];
