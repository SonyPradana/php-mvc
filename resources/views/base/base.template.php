<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{% yield('title') %}</title>
    <link rel="stylesheet" href="src/css/app.css">
    <script src="src/js/app.js"></script>
</head>
<body class="bg-gray-100 flex w-screen h-screen">
    {% yield('content') %}
</body>
</html>