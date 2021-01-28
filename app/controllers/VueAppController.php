<?php

use System\Apps\Controller;

class VueAppController extends Controller
{
  public function index()
  {
    $error = array();

    return $this->view('VueApp', array (
      "meta"          => array (
        "title"         => "Vue Apps",
        "discription"   => "",
        "keywords"      => ""
      ),
      "contents" => array (

      ),
      'error' => $error,
      "message" => array()
    ));
  }
}
