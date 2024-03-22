{% extend('base/base.template.php') %}

{% section('title', '{{ $title }}') %}

{% section('content') %}
<div class="dark:bg-gray-800 text-gray-900 m-auto w-9/12 bg-white dark:text-gray-100">
    <h1 class="text-3xl font-bold dark:text-gray-100" id="title">{{ $say }}</h1>
    <p class="text-gray-700 dark:text-gray-400" id="time">php-library {{ \Composer\InstalledVersions::getPrettyVersion('sonypradana/php-library') }} (PHP v{{ phpversion() }})</p>

    <div class="grid grid-flow-row grid-cols-2 gap-4 py-2">
        <div class="p-2 min-h-24 rounded-md shadow-lg bg-gray-200 dark:bg-gray-700 border border-gray-200 dark:border-gray-800 hover:bg-opacity-[.9]">
            <div class="text-lg font-bold text-gray-900 dark:text-gray-100">Builtin CLI Command</div>
            <div class="text-md text-gray-500 dark:text-gray-300">Model, View, Controller and also services. just type 'php cli' on your terminal</div>
        </div>
        <div class="p-2 min-h-24 rounded-md shadow-lg bg-gray-200 dark:bg-gray-700 border border-gray-200 dark:border-gray-800 hover:bg-opacity-[.9]">
            <div class="text-lg font-bold text-gray-900 dark:text-gray-100">Builtin PDO and Query Builder</div>
            <div class="text-md text-gray-500 dark:text-gray-300">Easy and Fast database CRUD, with query builder ready to go</div>
        </div>
        <div class="p-2 min-h-24 rounded-md shadow-lg bg-gray-200 dark:bg-gray-700 border border-gray-200 dark:border-gray-800 hover:bg-opacity-[.9]">
            <div class="text-lg font-bold text-gray-900 dark:text-gray-100">Easy Routing configure</div>
            <div class="text-md text-gray-500 dark:text-gray-300">Build your costume API url is ready</div>
        </div>
        <div class="p-2 min-h-24 rounded-md shadow-lg bg-gray-200 dark:bg-gray-700 border border-gray-200 dark:border-gray-800 hover:bg-opacity-[.9]">
            <div class="text-lg font-bold text-gray-900 dark:text-gray-100">Template Engine</div>
            <div class="text-md text-gray-500 dark:text-gray-300">Template engine is also available for crafting pages using your own templates.</div>
        </div>
    </div>
</div>

{% endsection %}
