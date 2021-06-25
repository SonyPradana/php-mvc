<?php

use System\Apps\Command;
use System\Cron\Schedule;

class CronCommand extends Command
{

  public static array $command = array(
    [
      "cmd"       => "cron",
      "mode"      => "start",
      "class"     => self::class,
      "fn"        => "switcher",
    ],
  );

  public function printHelp()
  {
    return array(
      'option' => array(
        "\n\t" . $this->textGreen("cache") . ":info" . $this->tabs(5) . "Get cache information",
        "\n\t" . $this->textGreen("cache") . ":clear" . $this->tabs(5) . "Clear all cache",
        "\n\t" . $this->textGreen("cache") . ":clear [cache_prefix]" . $this->tabs(3) . "Clear cache with prefix items name",
      ),
      'argument' => array()
    );
  }

  public function switcher()
  {
    // get category command
    $makeAction = explode(':', $this->CMD);

    // stopwatch
    $watch_start = microtime(true);

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
          echo "#  ";
          if ($cron->isAnimusly()) {
            echo $this->textDim($cron->getTimeName()), "\t";
          } else {
            echo $this->textGreen($cron->getTimeName()), "\t";
          }

          echo $this->textYellow($cron->getEventname()), "\n";
        }
        break;

      case 'work':
        echo $this->textBlue("\nSimulate Cron in terminal (every minute)");
        echo $this->textGreen("\n\nCtrl+C to stop\n");

        while (1) {
          if (date('s') == 00) {
            echo $this->textDim("Run cron at - ". date("D, H i"));
            echo "\n";

            $this->scheduler($schedule = new Schedule());
            $schedule->execute();

            sleep(60);
          } else {
            sleep(1);
          }
        }
        break;

      default:
        echo $this->textRed("\nArgumnet not register");
        break;
    }

    // end stopwatch
    $watch_end = round(microtime(true) - $watch_start, 3) * 1000;
    echo "\nDone in " . $this->textYellow($watch_end ."ms\n");
  }

  public function scheduler(Schedule $schadule): void
  {
    $schadule->call(function() {
      echo "Its Cron Job Schaduller, run every 10 minute\n";
      return;
    })
    ->eventName("Run cron every 10")
    ->everyTenMinute();

    $schadule->call(function() {
      echo "Its Cron Job Schaduller, run every hour\n";
      return;
    })
    ->eventName("Run only 1 per hour")
    ->hourly();

    $schadule->call(function() {
      echo date("D, d M Y H:i:s"), "\n";
      return;
    })
    ->animusly()
    ->eventName("cron is works")
    ->justInTime();
  }
}
