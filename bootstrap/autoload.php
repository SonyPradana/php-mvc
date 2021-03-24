<?php

spl_autoload_register(function( $class ){
  $className = str_replace("\\", DIRECTORY_SEPARATOR, $class);

  // autoload controller
  if (file_exists(APP_FULLPATH['controllers'] . $className . '.php')) {
    require_once APP_FULLPATH['controllers'] . $className . '.php';
    return;
  }
  // autoload library
  if (file_exists( BASEURL . '/app/library/' . $className . '.php')) {
    require_once  BASEURL . '/app/library/' . $className . '.php';
    return;
  }

  // autoload services
  if (file_exists(APP_FULLPATH['services'] . $className . '.php')) {
    require_once APP_FULLPATH['services'] . $className . '.php';
    return;
  }

  // auto load commands
  if (file_exists(BASEURL . '/app/commands/' . $className . '.php')) {
    require_once BASEURL . '/app/commands/' . $className . '.php';
    return;
  }
});


