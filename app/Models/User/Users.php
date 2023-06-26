<?php

declare(strict_types=1);

namespace Model\User;

use System\Database\MyModel;
use System\Database\MyPDO;
use System\Support\Facades\PDO;

class Users extends MyModel
{
    public function __construct(MyPDO $pdo = null)
    {
        $this->_TABELS[]  = 'users';
        $this->PDO        = $pdo ?? PDO::instance();
    }
}
