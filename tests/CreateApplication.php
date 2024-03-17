<?php

declare(strict_types=1);

namespace Tests;

use System\Integrate\Application;

trait CreateApplication
{
    public function createApplication(): Application
    {
        $app = require dirname(__DIR__) . '/bootstrap/init.php';

        return $app;
    }
}
