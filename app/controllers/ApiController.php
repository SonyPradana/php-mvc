<?php

namespace App\Controllers;

use System\Http\Response;

class ApiController extends Controller
{
    public function index($unit, $action, $version)
    {
        $response = $this->getService($unit, $action, $version);

        $status = $response['code'] ?? 200;
        $header = $response['headers'] ?? [];
        unset($response['headers']);

        return (new Response())
          ->setContent($response)
          ->setResponeCode($status)
          ->setHeaders($header)
          ->removeHeader([
            'Expires',
            'Pragma',
            'X-Powered-By',
            'Connection',
            'Server',
          ])
          ->json();
    }

    protected function getService($service_nama, $method_nama, $version): array
    {
        $service_nama .= 'Service';
        $service_nama   = str_replace('-', '', $service_nama);
        $method_nama    = str_replace('-', '_', $method_nama);

        if (file_exists(services_path($service_nama . '.php'))) {
            $service = new $service_nama();
            if (method_exists($service, $method_nama)) {
                // call target services
                return app()->call([$service, $method_nama], ['version' => $version]);
            }

            // method not found
            return [
              'status'  => 'Bad Request',
              'code'    => 400,
              'error'   => [
                'server'  => 'Bad Request',
                'leyer'   => 1,
              ],
              'headers' => ['HTTP/1.1 400 Bad Request'],
            ];
        }

        // page not found
        return [
          'status'  => 'Service Not Found',
          'code'    => 404,
          'error'   => [
            'server'  => 'Service Not Found',
            'leyer'   => 1,
          ],
          'headers' => ['HTTP/1.1 404 Service Not Found'],
        ];
    }
}
