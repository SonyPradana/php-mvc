<?php

namespace Model\User;

use System\Database\MyCRUD;
use System\Support\Facades\PDO;

class User extends MyCRUD
{
    public function __construct()
    {
        $this->PDO        = PDO::instance();
        $this->TABLE_NAME = 'users';
    }
}
