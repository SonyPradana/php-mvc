<?php

namespace App\Commands;

use App\Commands\Cron\Log;
use System\Cron\Schedule;
use System\Integrate\Console\CronCommand as ConsoleCronCommand;

class CronCommand extends ConsoleCronCommand
{
    public function __construct($argv, $default_option = [])
    {
        parent::__construct($argv, $default_option);
        $this->log = new Log();
    }

    public static array $command = [
        [
            'cmd'       => 'cron',
            'mode'      => 'full',
            'class'     => self::class,
            'fn'        => 'main',
        ], [
            'cmd'       => 'cron:list',
            'mode'      => 'full',
            'class'     => self::class,
            'fn'        => 'list',
        ], [
            'cmd'       => 'cron:work',
            'mode'      => 'full',
            'class'     => self::class,
            'fn'        => 'work',
        ],
    ];

    public function scheduler(Schedule $schedule): void
    {
        $schedule->call(function () {
            return [
                'code' => 200,
            ];
        })
        ->retry(2)
        ->justInTime()
        ->animusly()
        ->eventName('savanna');

        // others schedule
    }
}
