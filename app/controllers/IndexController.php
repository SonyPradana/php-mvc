<?php

namespace App\Controllers;

class IndexController extends Controller
{
    public function index()
    {
        return $this->view('index', [
            'title' => 'Php is great',
            'say'   => 'hello, php enthusiastic!',
        ]);
    }
}
