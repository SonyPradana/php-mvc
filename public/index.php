<?php

if (file_exists($maintenance = dirname(__DIR__) . '/storage/app/maintenance.php')) {
    require $maintenance;
}

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
$karnel = $app->make(System\Integrate\Http\Karnel::class);

/**
 * Handle Respone from httpkarnel
 */
$response = $karnel->handle(
    $request = (new System\Http\RequestFactory())->getFromGloball()
)->send();

$karnel->terminate($request, $response);
