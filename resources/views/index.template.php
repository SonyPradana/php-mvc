{% extend('base/base.template.php') %}

{% section('title') %}
{{ title }}
{% endsection %}

{% section('content') %}
<div class="m-auto w-9/12  ">
    <h1 class="text-gray-900 text-3xl font-bold">{{ say }}</h1>
    <p class="text-gray-700">
        {% php %} echo now()->__toString(); {% endphp %}
    </p>
    <div class="grid grid-flow-row grid-cols-2 gap-4 py-2">
      <div class="p-2 rounded-md shadow-lg border-gray-700 bg-gray-50">
        <div class="text-lg font-semibold">Builtin CLI Command</div>
        <div class="text-md ">Model, View, Controller and also services. just type 'php cli' on your terminal</div>
      </div>
      <div class="p-2 rounded-md shadow-lg border-gray-700 bg-gray-50">
        <div class="text-lg font-semibold">Builtin PDO and Query Builder</div>
        <div class="text-md">Easy and Fast database CRUD, with query builder ready to go</div>
      </div>
      <div class="p-2 rounded-md shadow-lg border-gray-700 bg-gray-50">
        <div class="text-lg font-semibold">Easy Routing configure</div>
        <div class="text-md">Build your costume API url is ready</div>
      </div>
      <div class="p-2 rounded-md shadow-lg border-gray-700 bg-gray-50">
        <div class="text-lg font-semibold">Support tailwind and Vue </div>
        <div class="text-md">This page creat using tailwind css. Of course vue application is optional if you wont</div>
      </div>
    </div>
</div>
{% endsection %}
