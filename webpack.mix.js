let mix = require('laravel-mix');

// basic minify and sass builder
mix
  .js("resources/js/bundles.js", "public/src/js")
  .sass('resources/sass/style.scss', 'public/src/css/');

// tailwind config
mix
  .postCss("resources/css/app.css", "public/src/css", [
    require("tailwindcss")
  ]);

// vue router - optional
// mix.js('resources/vue/app.js', 'public/vue')
//   .postCss("resources/vue/css/app.css", "public/vue/css", [
//     require("tailwindcss"),
//   ])
