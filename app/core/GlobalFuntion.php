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
   * @param string $insert_path
   *  Insert string in end of path
   * @return string
   * Base path folder
   */
  function base_path(string $insert_path = ''): string {
    return BASEURL . $insert_path;
  }
}
if (! function_exists("model_path")) {

  /**
   * Get aplication model path, base on config file
   *
   * @param bool $include_basePath
   *  True to add base path to result
   * @return string
   *  Application path folder
   */
  function model_path(bool $include_basePath = false, string $surfix_path = ''): string {
    return $include_basePath
      ? (APP_FULLPATH['model'] ?? '') . $surfix_path
      : (APP_PATH['model'] ?? '') . $surfix_path;
  }
}

if (! function_exists("view_path")) {

  /**
   * Get aplication view path, base on config file
   *
   * @param bool $include_basePath
   *  True to add base path to result
   * @return string
   *  Application path folder
   */
  function view_path(bool $include_basePath = false, string $surfix_path = ''): string {
    return $include_basePath
      ? (APP_FULLPATH['view'] ?? '') . $surfix_path
      : (APP_PATH['view'] ?? '') . $surfix_path;
  }
}

if (! function_exists("controllers_path")) {

  /**
   * Get aplication controllers path, base on config file
   *
   * @param bool $include_basePath
   *  True to add base path to result
   * @return string
   *  Application path folder
   */
  function controllers_path(bool $include_basePath = false, string $surfix_path = ''): string {
    return $include_basePath
      ? (APP_FULLPATH['controllers'] ?? '') . $surfix_path
      : (APP_PATH['controllers'] ?? '') . $surfix_path;
  }
}

if (! function_exists("services_path")) {

  /**
   * Get aplication services path, base on config file
   *
   * @param bool $include_basePath
   *  True to add base path to result
   * @return string
   *  Application path folder
   */
  function services_path(bool $include_basePath = false, string $surfix_path = ''): string {
    return $include_basePath
      ? (APP_FULLPATH['services'] ?? '') . $surfix_path
      : (APP_PATH['services'] ?? '') . $surfix_path;
  }
}

if (! function_exists("component_path")) {

  /**
   * Get aplication component path, base on config file
   *
   * @param bool $include_basePath
   *  True to add base path to result
   * @return string
   *  Application path folder
   */
  function component_path(bool $include_basePath = false, string $surfix_path = ''): string {
    return $include_basePath
      ? (APP_FULLPATH['component'] ?? '') . $surfix_path
      : (APP_PATH['component'] ?? '') . $surfix_path;
  }
}

if (! function_exists("commands_path")) {

  /**
   * Get aplication commands path, base on config file
   *
   * @param bool $include_basePath
   *  True to add base path to result
   * @return string
   *  Application path folder
   */
  function commands_path(bool $include_basePath = false, string $surfix_path = ''): string {
    return $include_basePath
      ? (APP_FULLPATH['commands'] ?? '') . $surfix_path
      : (APP_PATH['commands'] ?? '') . $surfix_path;
  }
}

if (! function_exists("config_path")) {

  /**
   * Get aplication config path, base on config file
   *
   * @param bool $include_basePath
   *  True to add base path to result
   * @return string
   *  Application path folder
   */
  function config_path(bool $include_basePath = false, string $surfix_path = ''): string {
    return $include_basePath
      ? (APP_FULLPATH['config'] ?? '') . $surfix_path
      : (APP_PATH['config'] ?? '') . $surfix_path;
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

if (! function_exists("stringContains")) {
  /**
   * Cek text exis on text
   *
   * @param string $find
   *  Text to find
   * @param string $in
   *  Resource to find
   * @return bool
   *  True if find text in text
   */
  function stringContains(string $find, string $in): bool
  {
    return \Helper\String\Str::contains($find, $in);
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

// http

if (! function_exists('request')) {
  function request(): System\Http\Request
  {
    return (new System\Http\RequestFactory())->getFromGloball();
  }
}

if (! function_exists('response')) {
  function response($conten = '', int $respone_code = System\Http\Response::HTTP_OK, array $headers = []): System\Http\Response
  {
    return (new System\Http\Response($conten, $respone_code, $headers));
  }
}
