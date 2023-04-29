<?php

use System\Http\Response;

abstract class Service
{
    public const CODE_NO_CONTENT           = 204;
    public const CODE_BAD_REQUEST          = 400;
    public const CODE_UNAUTHORIZED         = 401;
    public const CODE_FORBIDDEN            = 403;
    public const CODE_NOT_FOUND            = 404;
    public const CODE_METHOD_NOT_ALLOWED   = 405;

    protected \DefaultService $error;

    public function __construct()
    {
        $this->error = new \DefaultService();
    }

    /**
     * return error handel
     * prettier from error property.
     *
     * @param int $error_code Error code (400, 403 or Services::CODE_NOT_FOUND)
     *
     * @return array Array error provider
     */
    protected function error(int $error_code = 404): array
    {
        // to prevent parent::_construct() not declare
        $this->error = null ?? new \DefaultService();

        // No Content
        if ($error_code === 204) {
            return $this->error->code_204();
        }

        // bad request
        if ($error_code === 400) {
            return $this->error->code_400();
        }

        // unauthorized
        if ($error_code === 401) {
            return $this->error->code_401();
        }

        // forbiden
        if ($error_code === 403) {
            return $this->error->code_403();
        }

        // method not allowed
        if ($error_code === 405) {
            return $this->error->code_405();
        }

        // default error
        return $this->error->code_404();
    }

    /**
     * handle error as a function on return array,
     * so can return error instanl.
     *
     * @param int $error_code http error code (400, 401, 403, 404, 405)
     *
     * @return void error handle
     */
    protected function errorHandler(int $error_code = 404): void
    {
        $repone     = $this->error($error_code);
        $headers[]  = array_values($repone['headers']);
        $headers[]  = 'Content-Type: application/json';

        (new Response($repone, $error_code, $headers))
      ->json()
      ->close();
    }
}
