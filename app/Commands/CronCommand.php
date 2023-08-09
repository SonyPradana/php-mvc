<?php

namespace App\Commands;

use App\Commands\Cron\Log;
use React\EventLoop\Loop;
use System\Console\Style\Style;
use System\Cron\Schedule;
use System\Integrate\Console\CronCommand as ConsoleCronCommand;
use System\Time\Now;

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

    public function work(): void
    {
        $print = new Style("\n");
        $print
            ->push('Simulate Cron in terminal (every minute)')->textBlue()
            ->new_lines(2)
            ->push('type ctrl+c to stop')->textGreen()->underline()
            ->out();

        Loop::addPeriodicTimer(60.00, function () {
            $clock = new Now();
            $print = new Style();
            $time  = $clock->year . '-' . $clock->month . '-' . $clock->day;

            $print
                ->push('Run cron at - ' . $time)->textDim()
                ->push(' ' . $clock->hour . ':' . $clock->minute . ':' . $clock->second);

            $watch_start = microtime(true);

            $this->scheduler($schedule = new Schedule(now()->timestamp, new Log()));
            $schedule->execute();

            $watch_end = round(microtime(true) - $watch_start, 3) * 1000;
            $print
                ->repeat(' ', 34 - $print->length())
                ->push('-> ')->textDim()
                ->push($watch_end . 'ms')->textYellow()
                ->out()
            ;
        });
    }

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
