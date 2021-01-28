<?php
use System\Apps\Config;

// Autoloading
require_once dirname(__DIR__) . '/bootstrap/autoload.php';

// Core
require_once dirname(__DIR__) . '/app/core/Config.php';
require_once dirname(__DIR__) . '/app/core/Router.php';
require_once dirname(__DIR__) . '/app/core/Controller.php';
require_once dirname(__DIR__) . '/app/core/CLI.php';

// Declare Config Class
$config = new Config();
