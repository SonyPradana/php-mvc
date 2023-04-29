<?php

namespace App\Controllers;

use System\Http\Response;

class VueAppController extends Controller
{
    public function index(): Response
    {
        $error = [];

        return $this->view('VueApp', [
          'title'         => 'Vue Apps',
          'discription'   => '',
          'keywords'      => '',
          'error'         => $error,
          'message'       => [],
        ]);
    }
}
