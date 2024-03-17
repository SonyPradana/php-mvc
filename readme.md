# PHP MVC

Php mvc with minum mvc framework (skeleton project). is simple and easy to use

## Feature
- MVC structur
- Router Support (with rest api ready to use)
- Models builder
- Query builder
- CLI command (wonderfull cli applicaion)
- Service Provider and Middleware

## Serve your apps (4 steps)
- Create application using composer
```bash
composer create-project sonypradana/php-mvc project-name
 ```
 - cd to `project-name`
 ```bash
 cd project-name
 ```
- Building recouce vite asset (css and js)
```bash
npm install
npm run build
```
- Serve your page
```bash
php cli serve
```
## Extra ✨
Build app with cli
```bash
# create migration schema
php cli make:migration profiles
php cli migrate

# create a model
php cli make:model Profile --table-name profiles

# create controller (or api services)
php cli make:controller Profile
php cli make:services Profile

# presenter as html response
php cli make:view profile
```
lets look some line of code
```php
# in Profile migration file (database/migration/<time_stamp>_profile.php)
Schema::table('users', function (Create $column) {
    $column('user')->varChar(32);
    $column('real_name')->varChar(100);

    $column->primaryKey('user');
})

# in controller (app/Controller/ProfileController.php)
public function index(MyPDO $pdo): Response
{
    return view('profiles', ['name' => Profile::find('pradana', $pdo)->real_name]);
}
# or services (app/services/ProfileServices.php)
public function index(MyPDO $pdo): array
{
    return [
        'name' => Profile::find('pradana', $pdo)->real_name,
        'status' => 200,
        'header' => []
    ];
}

# View template engine (resources/view/profile.templator.php)
// <html>
// <head></head>
// <body>
// <p>hay, {{ $name }}</p>
// </body>
// </html>

# router (route.web.php)
Router::get('/profile', Profile::class);
# or
Router::any('/api/profile', function ($version, $unit, $action) {
    return (new ApiController())->index($unit, $action, $version);
});
```
php-mvc is an open-sourced software licensed under the **[MIT license](https://opensource.org/licenses/MIT)**.
