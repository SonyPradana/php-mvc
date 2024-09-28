<?php

use App\Controllers\IndexController;
use System\Router\Router;

Router::get('/', [IndexController::class, 'index']);

Router::get('/say/(:any)', function ($text) {
    return "say $text";
});
