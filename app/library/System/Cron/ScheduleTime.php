<?php

namespace System\Cron;

use Model\CronLog\CronLog;

class ScheduleTime
{
  private $call_back;
  private $params = [];
  private $time;
  private $event_name = 'animus';


  public function __construct($call_back, $params, $time)
  {
    $this->call_back = $call_back;
    $this->params = $params;
    $this->time = $time;
  }

  public function eventName($val)
  {
    $this->event_name = $val;
    return $this;
  }

  private function exect(array $events)
  {
    $dayLetter  = date("D", $this->time);
    $day        = date("d", $this->time);
    $hour       = date("H", $this->time);
    $minute     = date("i", $this->time);


    foreach ($events as $event) {
      $eventDayLetter = $event['D'] ?? $dayLetter; // default day letter every event

      if ($eventDayLetter == $dayLetter
      && $event['d'] == $day
      && $event['h'] == $hour
      && $event['m'] == $minute) {

        // stopwatch
        $watch_start = microtime(true);

        // TODO: more call back support
        $out_put = call_user_func($this->call_back, $this->params) ?? [];

        // stopwatch
        $watch_end = round(microtime(true) - $watch_start, 3) * 1000;

        // put your command log here
        // code...
      }
    }
  }

  public function justInTime()
  {
    return $this->exect([
      [
        'D' => date('D', $this->time),
        'd' => date('d', $this->time),
        'h' => date('H', $this->time),
        'm' => date('i', $this->time)
      ]
    ]);
  }

  public function everyTenMinute()
  {
    $minute = [];
    for ($i=0; $i < 60; $i++) {

      if ($i % 10 == 0) {
        $minute[] = [
          'd' => date('d', $this->time),
          'h' => date('H', $this->time),
          'm' => $i
        ];
      }
    }

    return $this->exect($minute);
  }

  public function everyThirtyMinutes()
  {
    return $this->exect([
      [
        'd' => date('d', $this->time),
        'h' => date('H', $this->time),
        'm' => 0,
      ],
      [
        'd' => date('d', $this->time),
        'h' => date('H', $this->time),
        'm' => 30,
      ],
    ]);
  }

  public function everyTwoHour()
  {

    $thisDay = date("d", $this->time);
    $hourly = []; // from 00.00 to 23.00 (12 time)
    for ($i=0; $i < 24; $i++) {
      if ($i % 2 == 0) {
        $hourly[] = [
          'd' => $thisDay,
          'h' => $i,
          'm' => 0
        ];
      }
    }

    return $this->exect($hourly);
  }

  public function everyTwelveHour()
  {
    return $this->exect([
      [
        'd' => date('d', $this->time),
        'h' => 0,
        'm' => 0,
      ],
      [
        'd' => date('d', $this->time),
        'h' => 12,
        'm' => 0,
      ]
    ]);
  }

  public function hourly()
  {
    $hourly = []; // from 00.00 to 23.00 (24 time)
    for ($i=0; $i < 24; $i++) {
      $hourly[] = [
        'd' => date("d", $this->time),
        'h' => $i,
        'm' => 0
      ];
    }

    return $this->exect($hourly);
  }

  public function hourlyAt(int $hour24)
  {
    return $this->exect([
      [
        'd' => date('d', $this->time),
        'h' => $hour24,
        'm' => 0
      ]
    ]);
 }

  public function daily()
  {
    return $this->exect([
      // from day 1 to 31 (31 time)
      ['d' => date('d'), 'h' => 0, 'm' => 0],
    ]);
  }

  public function dailyAt(int $day)
  {
    return $this->exect([
      [
        'd' => $day,
        'h' => 0,
        'm' => 0,
      ]
    ]);
  }

  public function weekly()
  {
    return $this->exect([
      [
        'D' => "Sun",
        'd' => date('d', $this->time),
        'h' => 0,
        'm' => 0
      ],
    ]);
  }

  public function mountly()
  {
    return $this->exect([
      [
        'd' => 1,
        'h' => 0,
        'm' => 0
      ],
    ]);
  }

}
