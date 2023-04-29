<?php

namespace Application\Cron;

use System\Cron\Schedule as CronSchedule;

class Schedule extends CronSchedule
{
    public function call($call_back, $params = [])
    {
        return $this->pools[] = new ScheduleTime($call_back, $params, $this->time);
    }
}
