<?php

namespace App\Models\User;

use System\Database\MyCRUD;
use System\Support\Facades\PDO;

class User extends MyCRUD
{
    protected $TABLE_NAME = 'users';

    protected $PRIMERY_KEY = 'id';

    protected $COLUMNS = [
        'user' => null,
        'pwd'  => null,
    ];

    public function __construct()
    {
        $this->PDO = PDO::instance();
    }
}
