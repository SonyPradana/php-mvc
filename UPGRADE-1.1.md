UPGRADE FROM 1.0 to 1.1

php-mvc 1.1 improve application lifecycle.

Karnel
-----

* Added application terminate to bootstrap.
    *Before*
    ```php
    /**
    * Declare http karnel.
    *
    * @var System\Integrate\Http\Karnel
    */
    $respone = $app->make(System\Integrate\Http\Karnel::class);

    /**
    * Handle Respone from httpkarnel
    *
    * @var System\Http\Response
    */
    $respone->handle(
        $request = (new System\Http\RequestFactory())->getFromGloball()
    )->send();
    ```

    *After*
    ```php
    /**
    * Declare http karnel.
    *
    * @var System\Integrate\Http\Karnel
    */
    $karnel = $app->make(System\Integrate\Http\Karnel::class);

    /**
    * Handle Respone from httpkarnel
    */
    $response = $karnel->handle(
        $request = (new System\Http\RequestFactory())->getFromGloball()
    )->send();

    $karnel->terminate($request, $response);
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
