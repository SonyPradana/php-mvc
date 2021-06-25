<?php
use System\Apps\Config;

// Autoloading
require_once dirname(__DIR__) . '/bootstrap/autoload.php';

// Core
require_once dirname(__DIR__) . '/app/core/Config.php';
require_once dirname(__DIR__) . '/app/core/Router.php';
require_once dirname(__DIR__) . '/app/core/RouterFactory.php';
require_once dirname(__DIR__) . '/app/core/RouterProvider.php';
require_once dirname(__DIR__) . '/app/core/Controller.php';
require_once dirname(__DIR__) . '/app/core/CLI.php';
require_once dirname(__DIR__) . '/app/core/Service.php';
require_once dirname(__DIR__) . '/app/core/GlobalFuntion.php';

// Declare Config Class
return (new Config());
