<?php

use System\Integrate\Http\Karnel;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Load Application instan.
 *
 * @var System\Integrate\Applicationn
 */
$app = require_once dirname(__DIR__) . '/bootstrap/init.php';

/**
 * Declare http karnel.
 *
 * @var System\Integrate\Http\Karnel
 */
$respone = $app->make(Karnel::class);
