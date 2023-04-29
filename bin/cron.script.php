#!/usr/bin/env php
<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

// call CLI
$app = require_once dirname(__DIR__) . '/bootstrap/init.php';

$out = $app->make(System\Integrate\Console\Karnel::class);

$handle = $out->handle(['cli', 'cron']);

exit($handle);