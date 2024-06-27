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
---

* Change deprecated method
```php
-          $this->app->set('vite.gets', fn (): Vite => new Vite($this->app->public_path(), '/build/'));
-          $this->app->set('vite.location', fn (): string => $this->app->public_path() . '/build/manifest.json');
+          $this->app->set('vite.gets', fn (): Vite => new Vite($this->app->publicPath(), '/build/'));
+          $this->app->set('vite.location', fn (): string => $this->app->publicPath() . '/build/manifest.json');
```


