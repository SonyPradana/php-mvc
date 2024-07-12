<?php

declare(strict_types=1);

namespace App\Models;

use System\Database\MyModel\Model;

/**
 * @property string|null $user
 * @property string|null $password
 */
class User extends Model
{
    protected string $table_name  = 'users';
    protected string $primery_key = 'user';
}
