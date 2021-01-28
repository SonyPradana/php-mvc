<?php

  // autoload controller
  spl_autoload_register(function( $class ){
    $className = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    if (file_exists(APP_FULLPATH['controllers'] . $className . '.php')) {
      require_once APP_FULLPATH['controllers'] . $className . '.php';
    }
  });

  // autoload library
  spl_autoload_register(function( $class ){
    $className = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    if (file_exists( BASEURL . '/app/library/' . $className . '.php')) {
        require_once  BASEURL . '/app/library/' . $className . '.php';
    }
  });

  // autoload services
  spl_autoload_register(function( $class ){
    $className = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    if (file_exists(APP_FULLPATH['services'] . $className . '.php')) {
      require_once APP_FULLPATH['services'] . $className . '.php';
    }
  });
