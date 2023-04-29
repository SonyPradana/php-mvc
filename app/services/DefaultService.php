<?php

/**
 * Default array return for json format services.
 */
class DefaultService
{
    /**
     * No Content.
     *
     * @return array<string, mixed> No Content
     */
    public function code_204(): array
    {
        return [
      'status'  => 'No Content',
      'code'    => 204,
      'error'   => [
        'server' => 'No Content',
      ],
      'headers' => ['HTTP/1.1 400 No Content'],
    ];
    }

    /**
     * Bad Request.
     *
     * @return array<string, mixed> Bad Request
     */
    public function code_400(): array
    {
        return [
      'status'  => 'Bad Request',
      'code'    => 400,
      'error'   => [
        'server' => 'Bad Request',
      ],
      'headers' => ['HTTP/1.1 400 Bad Request'],
    ];
    }

    /**
     * Unauthorized.
     *
     * @return array<string, mixed> Unauthorized
     */
    public function code_401(): array
    {
        return [
      'status'  => 'Unauthorized',
      'code'    => 401,
      'error'   => [
        'server' => 'Unauthorized',
      ],
      'headers' => ['HTTP/1.1 401 Unauthorized'],
    ];
    }

    /**
     * Forbidden.
     *
     * @return array<string, mixed> Forbidden
     */
    public function code_403(): array
    {
        return [
      'status'  => 'Forbidden',
      'code'    => 403,
      'error'   => [
        'server' => 'Forbidden',
      ],
      'headers' => ['HTTP/1.1 403 Forbidden'],
    ];
    }

    /**
     * Service Not Found.
     *
     * @return array<string, mixed> Service Not Found
     */
    public function code_404(): array
    {
        return [
      'status'  => 'Service Not Found',
      'code'    => 404,
      'error'   => [
        'server' => 'Service Not Found',
      ],
      'headers' => ['HTTP/1.1 404 Service Not Found'],
    ];
    }

    /**
     * Method Not Allowed.
     *
     * @return array<string, mixed> Method Not Allowed
     */
    public function code_405(): array
    {
        return [
      'status'  => 'Method Not Allowed',
      'code'    => 405,
      'error'   => [
        'server' => 'Method Not Allowed',
      ],
      'headers' => ['HTTP/1.1 405 Method Not Allowed'],
    ];
    }
}
