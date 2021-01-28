<!DOCTYPE html>
<html lang="en">
<head>
  <?php include(APP_FULLPATH['component'] . '/meta/metatag.php') ?>

  <link rel="stylesheet" href="/vue/css/app.css">
</head>
<body>
  <!-- load vue app -->
  <main id="app" class="containe place-items-center">
    <navigation></navigation>
    <router-view class="container mx-auto"></router-view>
  </main>

  <script src="/vue/app.js"></script>
</body>
</html>
