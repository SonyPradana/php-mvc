<?php

use Application\Http\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return $this->view('index', [
            'contents' => [
                'say' => 'hello, php enthusiastic!',
            ],
        ]);
    }
}
