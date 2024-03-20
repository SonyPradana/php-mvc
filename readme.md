<p align="center">
<a href="https://packagist.org/packages/sonypradana/php-mvc"><img src="https://img.shields.io/packagist/dt/sonypradana/php-mvc" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/sonypradana/php-mvc"><img src="https://img.shields.io/packagist/v/sonypradana/php-mvc" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/sonypradana/php-mvc"><img src="https://img.shields.io/packagist/l/sonypradana/php-mvc" alt="License"></a>
</p>

# PHP MVC
Welcome to **php-mvc**, a minimal MVC framework designed to streamline your PHP development process. This lightweight framework offers essential features for building web applications while maintaining simplicity and ease of use.

## Feature
- MVC structure
- Application Container (power with [php-di](https://github.com/PHP-DI/PHP-DI))
- Router Support
- Models builder
- Query builder
- CLI command
- Service Provider and Middleware
- Templator (template engine)

## Getting Started in 4 Simple Steps

1. **Create Your Application**:

```bash
composer create-project sonypradana/php-mvc project-name
```

2. **Navigate to Your Project**:

```bash
cd project-name
```

3. **Build Your Assets**:

```bash
npm install
npm run build
```

4. **Serve Your Application**:

```bash
php cli serve
```

## Additional Features ✨

### CLI Commands for Building Your App

```bash
# Create migration schema
php cli make:migration profiles
php cli db:create # skip if database already exists
php cli migrate

# Create a model
php cli make:model Profile --table-name profiles

# Create controller (or API services)
php cli make:controller Profile
php cli make:services Profile

# Presenter for HTML response
php cli make:view profile
```

### Example Code Snippets

#### Migration Schema
```php
// database/migration/<timestamp>_profile.php

Schema::table('profiles', function (Create $column) {
    $column('user')->varChar(32);
    $column('real_name')->varChar(100);

    $column->primaryKey('user');
});
```

#### Controller
```php
// app/Controller/ProfileController.php

public function index(MyPDO $pdo): Response
{
    return view('profiles', [
        'name' => Profile::find('pradana', $pdo)->real_name
    ]);
}
```

#### Services (rest api out of the box)
Api ready to go `http://localhost:8080/api/profile/index`.
```php
// app/services/ProfileServices.php

public function index(MyPDO $pdo): array
{
    return [
        'name'   => Profile::find('pradana', $pdo)->real_name,
        'status' => 200,
        'header' => []
    ];
}
```

#### View
```php
// resources/views/profile.template.php

{% extend('base/base.template.php') %}

{% section('title', 'hay {{ $name }}') %}

{% section('content') %}
<p>{{ $name }}</p>
{% endsection %}
```

### Router Configuration
```php
// route/web.php

Router::get('/profile', Profile::class);
```

## License

php-mvc is open-source software licensed under the **[MIT license](https://opensource.org/licenses/MIT)**.
