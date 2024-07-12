<?php

use System\Database\MySchema\Table\Create;
use System\Support\Facades\Schema;

return [
    'up' => [
        Schema::table('users', function (Create $column) {
            $column('user')->varChar(36);
            $column('password')->varChar(448);
            $column('created_at')->timestamp()->null();
            $column('updated_at')->timestamp()->null();

            $column->primaryKey('user');
        }),

        Schema::table('accounts', function (Create $column) {
            $column('user')->varChar(36);
            $column('email')->varChar(448);
            $column('email_verified_at')->timestamp()->null();

            $column->unique('email');
            $column->primaryKey('user');
        }),
    ],
    'down' => [
        Schema::drop()->table('users'),
        Schema::drop()->table('accounts'),
    ],
];
