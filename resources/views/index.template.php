<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="src/css/app.css">
  <script src="src/js/app.js"></script>
</head>
<body class="antialias bg-gray-100">
  <h1 class="text-gray-900 text-2xl font-bold"><?= $content->say ?></h1>
  <p class="text-gray-700">hello <?= date('Y-M-d', time())  ?></p>
</body>
</html>
