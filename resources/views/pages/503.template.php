{% extend('base/base.template.php') %}

{% section('title', '503 | Service Unavailable') %}

{% section('content') %}
<div class="flex items-center justify-center w-screen h-screen bg-gray-50 dark:bg-gray-800">
    <p class="text-xl text-gray-800 dark:text-gray-200 md:text-md lg:text-2xl">503 | Service Unavailable</p>
</div>
{% endsection %}
