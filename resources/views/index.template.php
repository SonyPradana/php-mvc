{% extend('base/base.template.php') %}

{% section('title', '{{ $title }}') %}

{% section('content') %}
<div class="dark:bg-gray-800 text-gray-900 m-auto w-9/12 bg-white dark:text-gray-100">
    <h1 class="text-3xl font-bold dark:text-gray-100" id="title">{{ $say }}</h1>
    <p class="text-gray-700 dark:text-gray-300" id="time">PHP {{ phpversion() }}</p>

    <div class="grid grid-flow-row grid-cols-2 gap-4 py-2">
        <div class="p-2 min-h-24 rounded-md shadow-lg border-gray-700 bg-gray-200 dark:bg-gray-700">
            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">Builtin CLI Command</div>
            <div class="text-md text-gray-500 dark:text-gray-300">Model, View, Controller and also services. just type 'php cli' on your terminal</div>
        </div>
        <div class="p-2 min-h-24 rounded-md shadow-lg border-gray-700 bg-gray-200 dark:bg-gray-700">
            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">Builtin PDO and Query Builder</div>
            <div class="text-md text-gray-500 dark:text-gray-300">Easy and Fast database CRUD, with query builder ready to go</div>
        </div>
        <div class="p-2 min-h-24 rounded-md shadow-lg border-gray-700 bg-gray-200 dark:bg-gray-700">
            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">Easy Routing configure</div>
            <div class="text-md text-gray-500 dark:text-gray-300">Build your costume API url is ready</div>
        </div>
        <div class="p-2 min-h-24 rounded-md shadow-lg border-gray-700 bg-gray-200 dark:bg-gray-700">
            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">Support tailwind </div>
            <div class="text-md text-gray-500 dark:text-gray-300">This page created using tailwind css.</div>
        </div>
    </div>
</div>

{% endsection %}
