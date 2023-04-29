<?php

return array_merge(
    // help command
    App\Commands\HelpCommand::$command,
    // make somthink command
    App\Commands\MakeCommand::$command,
    // serve
    App\Commands\ServeCommand::$command,
    // cron
    App\Commands\CronCommand::$command,
    // route
    App\Commands\RouteCommand::$command,
    // more command here
);
