<?php

namespace System\Cron;

class Schadule
{
  private $time;

  public function __construct(int $time = null)
  {
    $this->time = $time ?? time();
  }

  public function call($call_back, $params = [])
  {
    // TODO: collact all funtion, and run in the end
    return new ScheduleTime($call_back, $params, $this->time);
  }
}
