<?php

/**
 * Default array return for json format services
 */
class DefaultService
{
  /**
   * No Content
   *
   * @return array No Content
   */
  public function code_204(): array
  {
    return array(
      'status'  => 'No Content',
      'code'    => 204,
      'error'   => array(
        'server' => 'No Content'
      ),
      'headers' => ['HTTP/1.1 400 No Content']
    );
  }

  /**
   * Bad Request
   *
   * @return array Bad Request
   */
  public function code_400(): array
  {
    return array(
      'status'  => 'Bad Request',
      'code'    => 400,
      'error'   => array(
        'server' => 'Bad Request'
      ),
      'headers' => ['HTTP/1.1 400 Bad Request']
    );
  }

  /**
   * Unauthorized
   *
   * @return array Unauthorized
   */
  public function code_401(): array
  {
    return array(
      'status'  => 'Unauthorized',
      'code'    => 401,
      'error'   => array(
        'server' => 'Unauthorized'
      ),
      'headers' => ['HTTP/1.1 401 Unauthorized']
    );
  }

  /**
   * Forbidden
   *
   * @return array Forbidden
   */
  public function code_403(): array
  {
    return array(
      'status'  => 'Forbidden',
      'code'    => 403,
      'error'   => array(
        'server' => 'Forbidden'
      ),
      'headers' => ['HTTP/1.1 403 Forbidden']
    );
  }

  /**
   * Service Not Found
   *
   * @return array Service Not Found
   */
  public function code_404(): array
  {
    return array(
      'status'  => 'Service Not Found',
      'code'    => 404,
      'error'   => array(
        'server' => 'Service Not Found'
      ),
      'headers' => ['HTTP/1.1 404 Service Not Found']
    );
  }

  /**
   * Method Not Allowed
   *
   * @return array Method Not Allowed
   */
  public function code_405(): array
  {
    return array(
      'status'  => 'Method Not Allowed',
      'code'    => 405,
      'error'   => array(
        'server' => 'Method Not Allowed'
      ),
      'headers' => ['HTTP/1.1 405 Method Not Allowed']
    );
  }
}
