<?php

use System\Router\Router;

// sample add contoller
Router::get('/', function() {
  return (new IndexController())->index();
});

// register router
Router::get('/say/(:any)', function($text) {
  echo "say $text";
});

// vue apps router - optional
// if you use vue-router (sub path) forget register router here
// Router::get('/(:text)', function() {
//   return (new VueAppController)->index();
// });


// also sopprt ap (json) format output
Router::any( '/API/(:any)/(:any)', function($unit, $action) {
  return (new ServicesController())->index($unit, $action, 'v1.0');
});

// default path 404, 405
Router::pathNotFound(function($path) {
  echo "page not found -\n $path";
});
Router::methodNotAllowed(function($path, $method) {
  echo "method not allow \n $path with $method";
});
