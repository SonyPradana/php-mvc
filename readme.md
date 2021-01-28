# PHP MVC

php mvc with minum mvc frame work. is simple and easy to use

## Feature
- mvc structur
- re-use mvc (easy to maintenance)
- [Router](http://github.com/steampixel/simplePHPRouter) Support
- models bulider
- query bulider
- secure 'public/' folder
- builtin npm (sass, traser) -> minify css, js
- CLI command

## Optional Feature
- laravel-mix
- tailwind css
- vue router

this app is ready to use vue route, be default vue route is disable using comment. if you want just remove comment and run your ```npm```.

- laravel mix
```js
// vue router - optional
// mix.js('resources/vue/app.js', 'public/vue')
//   .postCss("resources/vue/css/app.css", "public/vue/css", [
//     require("tailwindcss"),
//   ])
```
- router
```php
// vue apps router - optional
// if you use vue-router (sub path) forget register router here
// Route::get('/(:text)', function() {
//   return (new VueAppController)->index();
// });
```

## serve your apps (4 steps)
- clone this repository
```bash
git clone https://github.com/SonyPradana/php-mvc my-project-name
 ```
 - composer update
 ```bash
 composer insatall
 ```
- building recouce css / js (optional)
```bash
npm install
npm run dev
```
- serve your page
```bash
php -S 127.0.0.1:3000 -t public/
```
## built in cli command
### make controll and view
```bash
php cli make:controller controllerName
```
### make model /models
model name is singular
```bash
php cli make:model user --table-name=users
php cli make:models user --table-name=users
```
before you make model, make sure database config has set.
to config your database you must copy ```.env.example``` to ```.env```.

## Update adn Maintenance  
this repository will be maintans every thursday or friday (probely 😅)
