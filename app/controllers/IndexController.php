<?php

namespace App\Controllers;

use System\Http\Response;

class IndexController extends Controller
{
    public function index(): Response
    {
        return $this->view('index', [
            'title' => 'Php is great',
            'say'   => 'hello, php enthusiastic!',
        ]);
    }
}
