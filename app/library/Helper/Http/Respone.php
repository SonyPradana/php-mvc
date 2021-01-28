<?php

namespace Helper\Http;

class Respone
{
  public static function print(array $body, int $status_code, array $headers, $exit_after = false)
  {
    // print status code (header) -- shorthand
    if ($status_code === 200) {
      header("HTTP/1.1 200 Oke");
      $body['status'] = 'ok';
    } elseif ($status_code == 400) {
      header("HTTP/1.1 401 Unauthorized");
      $body['status'] = 'unauthorized';
    } elseif ($status_code === 401) {
      header("HTTP/1.1 403 Access Denied");
      $body['status'] = 'access dinied';
    }

    // costume header if needed
    foreach ($headers['headers'] as $header) {
      header($header);
    }

    // print as json file
    echo json_encode($body, JSON_NUMERIC_CHECK);

    if ($exit_after){
      return exit();
    }
  }

  public static function headers(): array
  {
    $respone = array();
    $request = Request::getHeaders();

    // handle Caching
    $cacheControl = $request['Cache-Control'] ?? null;
    $pragmaControl = $request['Pragma'] ?? null;

    if ($cacheControl != null) {
      $respone['Cache-Control'] = 'Cache-Control: ' . $cacheControl;
    }
    if ($pragmaControl != null) {
      $respone['Pragma'] = 'Pragma: ' . $pragmaControl;
    }

    return $respone;
  }
}
