<?php

namespace App\Commands;

use Application\Cron\Schedule;
use System\Console\Command;
use System\Time\Now;

use function System\Console\style;

class CronCommand extends Command
{
    public static array $command = [
      [
        'cmd'       => 'cron',
        'mode'      => 'start',
        'class'     => self::class,
        'fn'        => 'switcher',
      ],
    ];

    public function printHelp()
    {
        return [
          'commands' => [
            'cron'      => 'Run cron job (all shadule)',
            'cron:work' => 'Run virtual cron job in terminal',
          ],
          'options'   => [],
          'relation'  => [],
        ];
    }

    public function switcher()
    {
        // get category command
        $makeAction = explode(':', $this->CMD);

        // stopwatch
        $watch_start = microtime(true);

        // property

        // find router
        switch ($makeAction[1] ?? '') {
            case '':
                $this->scheduler($schedule = new Schedule());
                $schedule->execute();
                break;

            case 'list':
                echo "\n";
                $this->scheduler($schedule = new Schedule());
                foreach ($schedule->getPools() as $cron) {
                    echo '#  ';
                    if ($cron->isAnimusly()) {
                        style($cron->getTimeName())->textDim()->push("\t")->out(false);
                    } else {
                        style($cron->getTimeName())->textGreen()->push("\t")->out(false);
                    }
                    style($cron->getEventname())->textYellow()->out();
                }
                break;

            case 'work':
                style("\nSimulate Cron in terminal (every minute)")->textBlue()
                    ->push("\n\nCtrl+C to stop")->textGreen()->underline()->out();

                while (true) {
                    $clock = new Now();
                    if ($clock->second === 0) {
                        $time = $clock->year . '-' . $clock->month . '-' . $clock->day;

                        style('Run cron at - ' . $time)->textDim()->push(' ' . $clock->hour . ':' . $clock->minute . ':' . $clock->second)->out(false);

                        $watch_start = microtime(true);

                        $this->scheduler($schedule = new Schedule());
                        $schedule->execute();

                        $watch_end = round(microtime(true) - $watch_start, 3) * 1000;
                        style("\t-> ")->textDim()->push($watch_end . 'ms')->textYellow()->out();

                        sleep(60);
                    } else {
                        sleep(1);
                    }
                }
                break;

            default:
                style("\nArgumnet not register")->out(false);
                break;
        }

        // end stopwatch
        $watch_end = round(microtime(true) - $watch_start, 3) * 1000;
        style("\nDone in ")->push($watch_end . 'ms')->bgYellow()->textDarkGray()->out();
    }

    public function scheduler(Schedule $schadule): void
    {
        // others schedule
    }
}
