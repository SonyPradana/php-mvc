<?php

use System\Apps\Controller;

class IndexController extends Controller
{
  public function index()
  {
    return $this->view('index', array (
      'contents' => array (
        'say' => 'hello'
      )
    ));
  }
}
