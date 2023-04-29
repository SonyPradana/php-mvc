<?php

namespace App\Controllers;

class VueAppController extends Controller
{
    public function index()
    {
        $error = [];

        return $this->view('VueApp', [
      'meta'          => [
        'title'         => 'Vue Apps',
        'discription'   => '',
        'keywords'      => '',
      ],
      'contents' => [
      ],
      'error'   => $error,
      'message' => [],
    ]);
    }
}
