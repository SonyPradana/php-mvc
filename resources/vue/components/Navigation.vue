<template>
  <div class="flex place-items-center">
    <ul class="flex max-w-4xl mx-auto space-x-4">
      <li>
        <router-link :to="{ name: 'home' }" class="text-gray-700 focus:text-gray-900">Home</router-link>
      </li>
      <li>
        <router-link :to="{ name: 'about' }" class="text-gray-700 focus:text-gray-900">About</router-link>
      </li>
    </ul>
  </div>
</template>

<script>
  export default {

  }
</script>

<style>

</style>
