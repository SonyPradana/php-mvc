<?php

declare(strict_types=1);

use System\Support\Facades\Schedule;

Schedule::call(static function () {
    return [
        'code' => 200,
        'data' => 'hai'
    ];
})
    ->everyTenMinute()
    ->animusly()
    ->eventName('schedule.from.routes');
