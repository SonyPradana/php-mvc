<?php

use System\Apps\Controller;

/**
 * this controller use for call all api (servises)
 * this frist-layer and end-layer before user request,
 * and after service end (respone).
 *
 * be default all services respone with json format adn header
 */
class ServicesController extends Controller
{
    /**
     * call all service functio over index.
     *
     * @param string $unit    Services class name
     * @param string $action  $service function/method name
     * @param string $version $version version controll of API call
     */
    public function index($unit, $action, $version): void
    {
        $response = $this->getService(
      $unit . 'Service',
      $action,
      request()
        ->with(['x-version' => $version])
        ->allIn()
    );

        response()
      ->setContent($response)
      ->setResponeCode($response['code'] ?? 200)
      ->setHeaders($response['headers'] ?? [])
      ->removeHeader([
        'Expires',
        'Pragma',
        'X-Powered-By',
        'Connection',
        'Server',
      ])
      ->json();
    }

    /**
     * helper to use USER_CALL_FACTION.
     */
    private function getService($service_nama, $method_nama, $args = []): array
    {
        $service_nama   = str_replace('-', '', $service_nama);
        $method_nama    = str_replace('-', '_', $method_nama);

        if (file_exists(APP_FULLPATH['services'] . $service_nama . '.php')) {
            $service = new $service_nama();
            if (method_exists($service, $method_nama)) {
                return call_user_func_array([$service, $method_nama], $args) ?? [];
            }

            return [
        'status'  => 'Service Not Found',
        'code'    => 404,
        'message' => "Service not found $service_nama",
        'headers' => ['HTTP/1.1 404 Service Not Foud'],
      ];
        }

        return [
      'status'  => 'Bad Request',
      'code'    => 400,
      'message' => APP_FULLPATH['services'] . $service_nama,
      'headers' => ['HTTP/1.1 400 Bad Request'],
    ];
    }
}
