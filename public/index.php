<?php

//  call core apps
require_once dirname(__DIR__) . '/vendor/autoload.php';

use System\Apps\Route;

// sample add contoller
Route::get('/', function() {
  return (new IndexController())->index();
});

// register router
Route::get('/say/(:any)', function($text) {
  echo "say $text";
});

// vue apps router - optional
// if you use vue-router (sub path) forget register router here
// Route::get('/(:text)', function() {
//   return (new VueAppController)->index();
// });


// also sopprt ap (json) format output
Route::match(['get', 'put', 'post', 'delete'], '/API/(:any)/(:any)', function($unit, $action) {
  return (new ServicesController())->index($unit, $action, 'v1.0');
});

// default path 404, 405
Route::pathNotFound(function($path) {
  echo "page not found -\n $path";
});
Route::methodNotAllowed(function($path, $method) {
  echo "method not allow \n $path with $method";
});

Route::run('/');
