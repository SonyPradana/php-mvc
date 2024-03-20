{% extend('base/base.template.php') %}

{% section('title') %}
404 | Page not found
{% endsection %}

{% section('content') %}
<div class="flex items-center justify-center w-screen h-screen bg-gray-50 dark:bg-gray-800">
    <p class="text-xl text-gray-800 dark:text-gray-100 md:text-md lg:text-2xl">404 | Page Not Found</p>
</div>
{% endsection %}
