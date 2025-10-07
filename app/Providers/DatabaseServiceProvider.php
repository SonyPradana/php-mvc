<?php

declare(strict_types=1);

namespace App\Providers;

use System\Database\DatabaseManager;
use System\Database\MyPDO;
use System\Database\MyQuery;
use System\Database\MySchema;
use System\Integrate\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $configs     = $this->app->get('config');
        $default     = $configs['db.default'];
        $connentions = $configs['db.connections'];
        $dsn         = $connentions[$default];

        $this->app->set('dsn.default', $default);
        $this->app->set('dsn.connenctions', $connentions);
        $this->app->set('dsn.sql', $dsn);

        $this->app->set(
            MyPDO::class,
            fn () => new MyPDO($this->app->get('dsn.sql'))
        );

        $this->app->set(
            MySchema\MyPDO::class,
            fn () => new MySchema\MyPDO($this->app->get('dsn.sql'))
        );

        $this->app->set(
            'MyQuery',
            fn () => new MyQuery($this->app->get(MyPDO::class))
        );

        $this->app->set(
            'MySchema',
            fn () => new MySchema($this->app->get(MySchema\MyPDO::class), $this->app->get('dsn.sql')['database'])
        );

        $this->app->set(
            DatabaseManager::class,
            fn () => (new DatabaseManager($this->app->get('dsn.connenctions')))
                ->setDefaultConnection($this->app->get(MyPDO::class))
        );
    }
}
