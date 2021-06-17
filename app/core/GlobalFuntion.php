<?php

if (! function_exists("dd")) {
  /**
   * Print prity value and close apilication
   * @param mixed $value
   *  Value to be print
   * @param mixed $values
   *  Values to be print
   * @return void
   *  Print and Die
   */
  function dd($value, ...$values): void {
    die(var_dump($value, ...$values));
  }
}

// path aplication

if (! function_exists("app_path")) {

  /**
   * Get full aplication path, base on config file
   *
   * @param string $folder_name
   *  Application path name
   * @param bool $include_basePath
   *  True to add base path to result
   * @return string
   *  Application path folder
   */
  function app_path(string $folder_name, bool $include_basePath = false): string {
    return $include_basePath
      ? (APP_FULLPATH[$folder_name] ?? '')
      : (APP_PATH[$folder_name] ?? '');
  }
}

if (! function_exists("base_path")) {

  /**
   * Get base path
   *
   * @return string
   * Base path folder
   */
  function base_path(): string {
    return BASEURL;
  }
}

// string

if (! function_exists("startsWith")) {
  /**
   * Cek Text start with with
   *
   * @param string $find
   *  Text to find
   * @param string $in
   *  Resource to find
   * @return bool
   *  True if text find in resouce
   */
  function startsWith(string $find, string $in): bool {
    return \Helper\String\Str::startWith($find, $in);
  }
}

// contoller

if (! function_exists("view")) {
  /**
   * Return view file and fill with data
   *
   * @param string $view_name
   *  View file locaation
   * @param array $portal
   *  Data to serve in view file
   * @return void
   *  Raw html
   */
  function view(string $view_name, $portal = [])
  {
    // short hand to access content
    if (isset($portal['contents'])) {
      $content = (object) $portal['contents'];
    }

    // require component
    require_once app_path('view', true) . $view_name . '.template.php';
  }
}
