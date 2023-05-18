<?php

use System\Database\MySchema\Table\Create;
use System\Support\Facades\Schema;

return Schema::table('cron', function (Create $column) {
    $column('id')->int(4)->autoIncrement(true);
    $column('message')->varChar(300);
    $column('context')->varChar(1_000);
    $column('date_create')->int(15);

    $column->primaryKey('id');
});
