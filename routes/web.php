<?php

use App\Controllers\IndexController;
use System\Router\Router;

// sample add contoller
Router::get('/', [IndexController::class, 'index']);

// register router
Router::get('/say/(:any)', function($text) {
  echo "say $text";
});

// vue apps router - optional
// if you use vue-router (sub path) forget register router here
// Router::get('/(:text)', function() {
//   return (new VueAppController)->index();
// });