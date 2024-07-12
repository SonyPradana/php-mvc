UPGRADE FROM 1.1 to 2.0

php-mvc 2.0 improve application lifecycle.

Kernel
-----

* Change constructor parameter
```diff
// app\Kernels\ConsoleKernel.php and app\Kernels\HttpKernel.php
-  public function __construct(Container $app)
+  public function __construct(Application $app)
```

* Change typo namespace
```diff
// app\Kernels\HttpKernel.php
+  use System\Integrate\Http\Karnel as Kernel;

-  class HttpKernel extends Karnel
-  class HttpKernel extends Kernel
```
```diff
// app\Kernels\ConsoleKernel.php
+  use System\Integrate\Console\Karnel as Kernel;

-  class ConsoleKernel extends Karnel
+  class ConsoleKernel extends Kernel
```

HelpCommand
-----

* Return to default (perent)
```diff
// app\Commands\HelpCommand.php
-  use App\Karnels\ConsoleKernel;
-  public static array $command = [
-      [
-          'cmd'       => ['-h', '--help'],
-          'fn'        => [self::class, 'main'],
-      ], [
-          'cmd'       => '--list',
-          'fn'        => [self::class, 'commandList'],
-      ], [
-          'cmd'       => 'help',
-          'fn'        => [self::class, 'commandhelp'],
-      ],
-  ];

-  public function __construct($argv, $default_option = [])
-  {
-      parent::__construct($argv, $default_option);
-      $this->commands = ConsoleKernel::$command;
-  }
```

command.config.php
-----

* wrap command register
```diff
  return [
+      'commands' => []
  ]
```
* added new commands
```diff
+  System\Integrate\Console\ConfigCommand::$command,
+  System\Integrate\Console\PackageDiscoveryCommand::$command,
   // more command here
```

Gitignore
-----

* added gitignore for cache Application
```diff
// bootstrap\cache\.gitignore
+  *.php
```

* added gitigonre list
```diff
// bootstrap\cache\.gitignore
+  /.vscode
+  /.idea
```

Controller
-----

* Remove any Extends in Conteroller
```php
-  use System\Http\Response;
-  use System\Router\Controller as BaseController;

-  class Controller extends BaseController
+  class Controller
  {
-      /**
-       * @param array<string, mixed> $portal
-       */
-      public static function renderView(string $view, array $portal = []): Response
-      {
-          return view($view, $portal);
-      }
-
-      public static function viewExists(string $view): bool
-      {
-          return file_exists(view_path() . $view . '.template.php');
-      }
  }
```

ViewServiceProvider
-----

* Change deprecated method
```php
-          $this->app->set('vite.gets', fn (): Vite => new Vite($this->app->public_path(), '/build/'));
-          $this->app->set('vite.location', fn (): string => $this->app->public_path() . '/build/manifest.json');
+          $this->app->set('vite.gets', fn (): Vite => new Vite($this->app->publicPath(), '/build/'));
+          $this->app->set('vite.location', fn (): string => $this->app->publicPath() . '/build/manifest.json');
```

Shedule
-----

* Added Schedule route
```php
// routes\schedule.php
<?php

declare(strict_types=1);

use System\Support\Facades\Schedule;

Schedule::call(static function () {
    return [
        'code' => 200,
        'data' => 'hai'
    ];
})
    ->everyTenMinute()
    ->animusly()
    ->eventName('schedule.from.routes');
```

* Register Schedule
```php
// app\Providers\RouteServiceProvider.php
+        require_once base_path('/routes/schedule.php');
```
```php
// app\Providers\AppServiceProvider.php
+ use App\Commands\Cron\Log;
+ use System\Cron\Schedule;

+         // register schedule to containel
+         $this->app->set('cron.log', fn (): Log => new Log());
+         $this->app->set('schedule', fn (): Schedule => new Schedule(now()->timestamp, $this->app['cron.log']));
```

Migration
-----

* users table
```php
// database\migration\2024_07_12_210700_create_users_and_accounts.php
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
```

* User Model
```php
 - * @property string|null $pwd
 + * @property string|null $password
```

htaccess
-----

* public htaccess
```htaccess
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ index.php [QSA,L]
</IfModule>
```
