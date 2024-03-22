<?php

namespace App\Controllers;

use System\Http\Response;

class ApiController extends Controller
{
    public function index(string $unit, string $action, string $version): Response
    {
        $api = $this->getService($unit, $action, $version);

        $status   = array_key_exists('code', $api) ? (int) $api['code'] : 200;
        $header   = array_key_exists('headers', $api) ? $api['headers'] : [];
        unset($api['headers']);
        $response = new Response($api, $status);

        $response
            ->headers
            ->add($header)
            ->remove('Expires')
            ->remove('Pragma')
            ->remove('X-Powered-By')
            ->remove('Connection')
            ->remove('Server');

        return $response->json();
    }

    /**
     * @return array<string, mixed>
     */
    protected function getService(string $service_nama, string $method_nama, string $version): array
    {
        $service_nama .= 'Service';
        $service_nama = str_replace('-', '', $service_nama);
        $method_nama  = str_replace('-', '_', $method_nama);

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
