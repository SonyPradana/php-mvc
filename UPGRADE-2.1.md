UPGRADE FROM 2.0 to 2.1

Database
-----

* database configuration

config/database.config.php
```diff
-   'DB_HOST' => $_ENV['DB_HOST'] ?? 'localhost',
-   'DB_USER' => $_ENV['DB_USER'] ?? 'root',
-   'DB_PASS' => $_ENV['DB_PASS'] ?? '',
-   'DB_NAME' => $_ENV['DB_NAME'] ?? '',
+   'db.default'     => $_ENV['DB_CONNECTION'] ?? 'mysql',
+   'db.connections' => [
+       'mysql' => [ ... ],
+       'mariadb' => [ ... ],
+       'pgsql' => [ ... ],
+       'sqlite' => [ ...],
+       ],
+   ],
```

app\Providers\DatabaseServiceProvider.php
```diff
-    $configs = $this->app->get('config');
-    $sql_dsn = [
-        'host'           => $configs['DB_HOST'],
-        'user'           => $configs['DB_USER'],
-        'password'       => $configs['DB_PASS'],
-        'database_name'  => $configs['DB_NAME'],
-    ];
-
-    $this->app->set('dsn.sql', $sql_dsn);
+    $configs     = $this->app->get('config');
+    $default     = $configs['db.default'];
+    $connentions = $configs['db.connections'];
+    $dsn         = $connentions[$default];
+
+    $this->app->set('dsn.default', $default);
+    $this->app->set('dsn.connenctions', $connentions);
+    $this->app->set('dsn.sql', $dsn);

    $this->app->set(
        MyPDO::class,
-        fn () => new MyPDO($sql_dsn)
+        fn () => new MyPDO($this->app->get('dsn.sql'))
    );

    $this->app->set(
        MySchema\MyPDO::class,
-        fn () => new MySchema\MyPDO($sql_dsn)
+        fn () => new MySchema\MyPDO($this->app->get('dsn.sql'))
    );

    $this->app->set(
        'MyQuery',
        fn () => new MyQuery($this->app->get(MyPDO::class))
    );

    $this->app->set(
        'MySchema',
-        fn () => new MySchema($this->app->get(MySchema\MyPDO::class))
+        fn () => new MySchema($this->app->get(MySchema\MyPDO::class), $this->app->get('dsn.sql')['database'])
        );
```

* database manager

app\Providers\DatabaseServiceProvider.php
```diff
+    $this->app->set(
+        DatabaseManager::class,
+        fn () => (new DatabaseManager($this->app->get('dsn.connenctions')))
+            ->setDefaultConnection($this->app->get(MyPDO::class))
+    );
```

Route
----

* Cache-able Route

app\Providers\RouteServiceProvider.php

```diff
-    Router::middleware([
-        // middleware
-        AppMiddleware::class,
-    ])->group(
-        fn () => [
-            require_once base_path('/routes/web.php'),
-            require_once base_path('/routes/api.php'),
-        ]
-    );
+    if (file_exists($cache = $this->app->getApplicationCachePath() . 'route.php')) {
+        $routes = (array) require $cache;
+        foreach ($routes as $route) {
+            Router::addRoutes($route);
+        }
+    } else {
+        Router::middleware([
+            // middleware
+            AppMiddleware::class,
+        ])->group(
+            fn () => [
+                require_once base_path('/routes/web.php'),
+                require_once base_path('/routes/api.php'),
+            ]
+        );
+    }
```

app\services\IndexService.php
```php
<?php

use App\Middlewares\AppMiddleware;
use System\Http\JsonResponse;
use System\Router\Attribute\Middleware;
use System\Router\Attribute\Name;
use System\Router\Attribute\Prefix;
use System\Router\Attribute\Route\Get;

#[Prefix('/api/v1')]
#[Middleware([AppMiddleware::class])]
final class IndexService
{
    #[Name('api.v1.index')]
    #[Get('/index')]
    public function index(): JsonResponse
    {
        return new JsonResponse([
            'say' => 'hello',
        ]);
    }
}
```

config\command.config.php
```diff
+ System\Integrate\Console\RouteCacheCommand::$command,
```
routes\api.php
```diff
- // also sopport (json) format output
- Router::any('/API/(:any)/(:any)', function ($unit, $action) {
-     return (new ApiController())->index($unit, $action, 'v1.0');
- });
+ // register router using attribute
+ Router::register([
+     IndexService::class,
+     // add more class
+ ]);
```

routes\web.php
```diff
- Router::get('/', [IndexController::class, 'index']);
+ Router::get('/', [IndexController::class, 'index'])->name('home.page');

- Router::get('/say/(:any)', function ($text) {
-     return "say $text";
- });
+ // Router::get('/say/(text:any)', function ($text) {
+ //     return "say $text";
+ // });
```

Vite
----

* Register vite directive for template engine

app\Providers\ViewServiceProvider.php
```diff
     public function boot()
     {
         $this->registerViteResolver();
         $this->registerViewResolver();
+         $this->registerViteDirectives();
     }

+    protected function registerViteDirectives(): void
+    {
+        if ($this->app->has('vite.gets')) {
+            DirectiveTemplator::register('vite', function (array $attributes): string {
+                $vite = $this->app->get('vite.gets');
+                return $vite(...$attributes);
+            });
+        }
+    }
```

* Usage in template (e.g. `resources/views/base/base.template.php`):

```html
{% if ($vite_has_manifest) %}
-    <?php echo $vite_hmr_script; ?>
-    <link rel="stylesheet" href="{{ vite('resources/css/app.css') }}">
-    <script type="module" src="{{ vite('resources/js/app.js') }}"></script>
+    {% vite(['resources/css/app.css', 'resources/js/app.js']) %}
{% endif %}
```

Rate Limiter
----

app\services\IndexService.php
```php
<?php

declare(strict_types=1);

namespace App\Providers;

use System\Cache\CacheManager;
use System\Integrate\Http\Middleware\ThrottleMiddleware;
use System\Integrate\ServiceProvider;
use System\RateLimiter\RateLimiterFactory;

class RateLimiterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerRatelimitterResolver();
        $this->registerThrottleMiddleware();
    }

    protected function registerRatelimitterResolver(): void
    {
        /** @var CacheManager */
        $cache   = $this->app->get('cache');
        $rate    = new RateLimiterFactory($cache);

        $this->app->set(RateLimiterFactory::class, fn () => $rate);
    }

    protected function registerThrottleMiddleware(): void
    {
        $rate = $this->app[RateLimiterFactory::class];
        $this->app->set(ThrottleMiddleware::class, fn () => new ThrottleMiddleware(
            limiter: $rate->createFixedWindow(
                limit: 60,
                windowSeconds: 60,
            ))
        );
    }
}
```

config\app.config.php
```diff
+ App\Providers\RateLimiterServiceProvider::class,
```

Error Handler
----

* prevent `filp/whoops` expose in production

before this change we cant run `composer install --no-dev --optimize-autoloader` because whoops require in dev dependency, the php cant find package in production.

```diff
- /** @var \Whoops\Run */
- private $run;
-
- /** @var \Whoops\Handler */
- private $handler;

 public function __construct(Application $app)
 {
        parent::__construct($app);

        $this->app->bootedCallback(function () {
-        /* @var \Whoops\Handler\PlainTextHandler */
-        $this->handler = $this->app->make('error.PlainTextHandler');
+        if ($this->app->isDebugMode() && class_exists(\Whoops\Run::class)) {
+            /* @var \Whoops\Handler\PlainTextHandler */
+            $handler = $this->app->make('error.PlainTextHandler');
-        /* @var \Whoops\Run */
-        $this->run = $this->app->make('error.handle');
-        $this->run
-            ->pushHandler($this->handler)
-            ->register();
+            /* @var \Whoops\Run */
+            $run = $this->app->make('error.handle');
+            $run
+              ->pushHandler($handler)
+              ->register();
+        }
        });
    }
```

app\Kernels\HttpKernel.php
```diff
-   /** @var \Whoops\Run */
-   private $run;
-   /** @var \Whoops\Handler */
-   private $handler;
    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->app->bootedCallback(function () {
-           if ($this->app->isDebugMode()) {
+                $handler = $this->app->make('error.PrettyPageHandler');
+                $handler->setPageTitle('php mvc');

                /* @var \Whoops\Run */
-               $this->run = $this->app->make('error.handle');
-               $this->run
-                 ->pushHandler($this->handler)
+                $run = $this->app->make('error.handle');
+                $run
+                  ->pushHandler($handler)
                   ->register();
            }
        });
```

app\Providers\AppServiceProvider.php
```diff
     public function boot()
     {
         // error handle
-        $this->app->set('error.handle', fn () => new \Whoops\Run());
-        $this->app->set('error.PrettyPageHandler', fn () => new \Whoops\Handler\PrettyPageHandler());
-        $this->app->set('error.PlainTextHandler', fn () => new \Whoops\Handler\PlainTextHandler());
+        $this->registerErrorHandle();


+    private function registerErrorHandle(): void
+    {
+        if ($this->app->isDebugMode() && class_exists(\Whoops\Run::class)) {
+            $this->app->set('error.handle', fn () => new \Whoops\Run());
+            $this->app->set('error.PrettyPageHandler', fn () => new \Whoops\Handler\PrettyPageHandler());
+            $this->app->set('error.PlainTextHandler', fn () => new \Whoops\Handler\PlainTextHandler());
+        }
+    }
```
