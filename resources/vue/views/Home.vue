<template>
  <div>
    <h1 class="text-2xl text-gray-900 text-bold">
      Hay {{ say }}, welcome to vue-router (SPA page)
    </h1>
    <p>Its fast</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      say: "php developer"
    }
  },
}
</script>
