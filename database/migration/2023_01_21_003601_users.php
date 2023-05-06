<?php

use System\Database\MySchema\Table\Create;
use System\Support\Facades\Schema;

return Schema::table('users', function (Create $column) {
    $column('user')->varChar(32);
    $column('pwd')->varChar(500);

    $column->primaryKey('user');
});
