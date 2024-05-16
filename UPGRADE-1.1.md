UPGRADE FROM 1.0 to 1.1

php-mvc 1.1 improve application lifecycle.

> php-library version 0.33 now end support for php 7.4. If you strill using php 7.4 use php-library 0.32.x, this version still accept bug and security update (small feature for improving performance).

Karnel
-----

* Added application terminate to bootstrap.
```diff
    /**
    * Declare http karnel.
    *
    * @var System\Integrate\Http\Karnel
    */
+    $karnel = $app->make(System\Integrate\Http\Karnel::class);

    /**
+    * Handle Respone from httpkarnel
    */
+    $response = $karnel->handle(
+        $request = (new System\Http\RequestFactory())->getFromGloball()
    )->send();

+    $karnel->terminate($request, $response);
```

Maintenace Command
-----
* Added maintenance command.

Exception
-----
* Added exception lifesycle for handle render exception and report exception.
```diff
// bootstrap.php

+   $app->set(
+           System\Integrate\Exceptions\Handler::class,
+       fn () => new Handler($app)
+   );
```

```diff
// app/Exceptions/Handler

+    <?php
+
+    namespace App\Exceptions;
+
+    use System\Integrate\Exceptions\Handler as BaseHandler;
+
+    class Handler extends BaseHandler
+    {
+
+    }
```

Favico
-----
* Added default favico.

Resource view
-----
* Added more default pages (400, 401,403, 429, 500).

ViewServiceProvider
-----
* Added `view.instace`, `TemplatorFinder::class`, `vite.location`, `vite.hasManifest` to container
```diff
+public function boot()
+    {
+        $this->registerViteResolver();
+        $this->registerViewResolver();
+    }
+
+    protected function registerViteResolver(): void
+    {
+        $this->app->set('vite.gets', fn (): Vite => new Vite($this->app->public_path(), '/build/'));
+        $this->app->set('vite.location', fn (): string => $this->app->public_path() . '/build/manifest.json');
+        $this->app->set('vite.hasManifest', fn (): bool => file_exists($this->app->get('vite.location')));
+    }
+
+    protected function registerViewResolver(): void
+    {
+        $global_template_var = [
+            'vite_has_manifest' => $this->app->get('vite.hasManifest'),
+        ];
+        $extensions = $this->app->get('config')['VIEW_EXTENSIONS'] ?? [];
+
+        $this->app->set(TemplatorFinder::class, fn () => new TemplatorFinder(view_paths(), $extensions));
+        $this->app->set('view.instance', fn () => new Templator($this->app->get(TemplatorFinder::class), compiled_view_path()));
+        $this->app->set(
+            'view.response',
+            fn () => fn (string $view, array $data = []): Response => new Response(
+                $this->app->get('view.instance')->render($view, array_merge($data, $global_template_var))
+            )
+        );
+    }
```

Restructur Tests Folder
-----
```bash
php-mvc/
└── tests/
    └── Feature/
    └── Unit/
```
