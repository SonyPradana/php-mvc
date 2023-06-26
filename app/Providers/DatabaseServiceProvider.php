<?php

declare(strict_types=1);

namespace App\Providers;

use System\Database\MyPDO;
use System\Database\MyQuery;
use System\Database\MySchema;
use System\Integrate\ServiceProvider;
use System\Support\Facades\PDO;

class DatabaseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $configs = $this->app->get('config');
        $sql_dsn = [
          'host'           => $configs['DB_HOST'],
          'user'           => $configs['DB_USER'],
          'password'       => $configs['DB_PASS'],
          'database_name'  => $configs['DB_NAME'],
        ];

        $this->app->set('dsn.sql', $sql_dsn);

        $this->app->set(
            \System\Database\MyPDO::class,
            fn () => new MyPDO($sql_dsn)
        );

        $this->app->set(
            \System\Database\MySchema\MyPDO::class,
            fn () => new \System\Database\MySchema\MyPDO($sql_dsn)
        );

        $this->app->set(
            'MyQuery',
            fn () => new MyQuery($this->app->get(\System\Database\MyPDO::class))
        );

        $this->app->set(
            'MySchema',
            fn () => new MySchema($this->app->get(\System\Database\MySchema\MyPDO::class))
        );

        // register facede
        new PDO($this->app);
    }
}
