<?php

namespace Application\Cron;

use System\Cron\ScheduleTime as CronScheduleTime;

class ScheduleTime extends CronScheduleTime
{
    protected function interpolate($message, array $contex)
    {
        // Logger for schedule
    }
}
