<?php

use App\Controllers\IndexController;
use System\Router\Router;

Router::get('/', [IndexController::class, 'index'])->name('home.page');

// Router::get('/say/(text:any)', function ($text) {
//     return "say $text";
// });
