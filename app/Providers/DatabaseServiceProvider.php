<?php

declare(strict_types=1);

namespace App\Providers;

use System\Database\MyPDO;
use System\Database\MyQuery;
use System\Database\MySchema;
use System\Integrate\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $configs    = $this->app->get('config');
        $default    = $configs['db.default'];
        $connention = $configs['db.connections'];

        $this->app->set('dsn.default', $default);
        $this->app->set('dsn.connenction', $connention);
        $this->app->set('dsn.use', $connention[$default]);
        $this->app->alias('dsn.use', 'dsn.sql');

        $this->app->set(
            MyPDO::class,
            fn () => new MyPDO($this->app->get('dsn.use'))
        );

        $this->app->set(
            MySchema\MyPDO::class,
            fn () => new MySchema\MyPDO($this->app->get('dsn.use'))
        );

        $this->app->set(
            'MyQuery',
            fn () => new MyQuery($this->app->get(MyPDO::class))
        );

        $this->app->set(
            'MySchema',
            fn () => new MySchema($this->app->get(MySchema\MyPDO::class))
        );
    }
}
