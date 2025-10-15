<p align="center">
<a href="https://packagist.org/packages/sonypradana/php-mvc"><img src="https://img.shields.io/packagist/dt/sonypradana/php-mvc" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/sonypradana/php-mvc"><img src="https://img.shields.io/packagist/v/sonypradana/php-mvc" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/sonypradana/php-mvc"><img src="https://img.shields.io/packagist/l/sonypradana/php-mvc" alt="License"></a>
</p>

# 🚀 PHP MVC Skeleton
Welcome to **php-mvc**, a minimal MVC framework designed to streamline your PHP development process. This lightweight framework offers essential features for building web applications while maintaining simplicity and ease of use.

## 🪐 Feature
- MVC structure
- Application Container (power with [php-di](https://github.com/PHP-DI/PHP-DI))
- Router Support
- Models builder
- Query builder
- CLI command
- Service Provider and Middleware
- Templator (template engine)

## 🎯 Quick Start (4 Steps)

### 1️⃣ Create Your Project
```bash
composer create-project sonypradana/php-mvc project-name
```

### 2️⃣ Jump In
```bash
cd project-name
```

### 3️⃣ Build Assets
```bash
npm install
npm run build
```

### 4️⃣ Launch!
```bash
php cli serve
```

**That's it!** Your app is now running. Let's build something awesome.


## 🎓 Building Your First Feature

We'll create a user profile feature from scratch.

### Step 1: Create Database Schema
```bash
php cli make:migration profiles
php cli db:create  # Only if database doesn't exist yet
```

Define your table structure:
```php
// database/migration/<timestamp>_profiles.php
Schema::table('profiles', function (Create $column) {
    $column('user')->varChar(32);
    $column('real_name')->varChar(100);
    $column->primaryKey('user');
})
```

Run the migration:
```bash
php cli migrate
```

### Step 2: Generate Your Model
```bash
php cli make:model Profile --table-name profiles
```

### Step 3: Create a Controller
```bash
php cli make:controller Profile
```

Add your logic:
```php
// app/Controller/ProfileController.php
public function index(MyPDO $pdo): Response
{
    return view('profile', [
        'name' => Profile::find('pradana', $pdo)->real_name
    ]);
}
```

### Step 4: Design Your View
```bash
php cli make:view profile
```

```php
// resources/views/profile.template.php
{% extend('base/base.template.php') %}
{% section('title', 'Welcome {{ $name }}') %}

{% section('content') %}
    <h1>Hello, {{ $name }}! 👋</h1>
{% endsection %}
```

### Step 5: Register Your Route
```php
// route/web.php
Router::get('/profile', [ProfileController::class, 'index']);
```

**Done!** Visit `/profile` and see your work in action.


## 🔥 Pro Move: API with Attributes

Skip the route files entirely. Use attributes for clean, self-documented APIs:

```bash
php cli make:services Profile
```

```php
// app/Services/ProfileServices.php
#[Get('/api/v1/profile')]
#[Name('api.v1.profile')]
#[Middleware([AuthMiddleware::class])]
public function index(MyPDO $pdo): array
{
    $data = Cache::remember('profile', 3600, fn () => [
        'name'   => Profile::find('pradana', $pdo)->real_name,
        'status' => 200,
    ]);

    return JsonResponse($data);
}
```
then register this route attribute.
```php
Router::register([
    ProfileServices::class,
    // add more class
]);
```

This automatically creates your route with middleware—no extra configuration needed!

**Equivalent traditional route:**
```php
Route::get('/api/v1/profile', [ProfileServices::class, 'index'])
    ->name('api.v1.profile')
    ->middleware([AuthMiddleware::class]);
```

## ⚡ Performance Optimization

Ready for production? Cache everything:

```bash
php cli view:cache    # Cache compiled templates
php cli config:cache  # Cache configuration
php cli route:cache   # Cache all routes
```

Your app will thank you with blazing-fast response times.

## 📄 License

Open source under the [MIT License](https://opensource.org/licenses/MIT). Build something amazing!
