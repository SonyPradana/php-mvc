# PHP MVC

php mvc with minum mvc frame work. is simple and easy to use

## Feature
- mvc structur
- re-use mvc (easy to maintenance)
- [Router](http://github.com/steampixel/simplePHPRouter) Support
- models builder
- query builder
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
### short hand to setup project
you can do manual by follow instruction before, or run this commend to easy setup (its same)
```bash
# type or copy this command to your terminal
./bin/setup.sh
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

## built in Query Builder
ofcource we are support CRUD data base, this a sample
### Select data 
```php
$db = new MyQuery();
$db('table_name')
  ->select(['column_1'])
  ->equal('column_2', 'fast_mvc')
  ->all();  
```
the result will show data from query,
its same with SQL query
```SQL
SELECT `column_1` FROM `table_name` WHERE (`column_2` = 'fast_mvc')
```
### Update data 
```php
$db = new MyQuery();
$db('table_name')
  ->update()
  ->value('column_3', 'simple_mvc')
  ->equal('column_2', 'fast_mvc')
  ->execute();  
```
the result is boolen true if sql success excute quert,
its same with SQL query
```SQL
UPDATE `table_name` SET `column_3` = 'simple_mvc' WHERE (`column_2` = 'fast_mvc')
```
### Also support Insert and Delete
```PHP
// insert
$db = new MyQuery();
$db('table_name')
  ->insert()
  ->value('column_1', '')
  ->value('column_2', 'simple_mvc')
  ->value('column_3', 'fast_mvc')
  ->execute();
// delete
$db('table_name')
  ->delete()
  ->equal('column_3', 'slow_mvc')
  ->execute();
```
its PDO supported, include cancel transation


## Update and Maintenance  
this repository will be maintans every thursday or friday (probely 😅)
