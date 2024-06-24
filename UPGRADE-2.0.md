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
