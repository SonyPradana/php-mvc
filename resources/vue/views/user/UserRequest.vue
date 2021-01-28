<template>
  <div>
    <h1 class="text-gray-900 dark:text-gray-200 text-2xl text-bold m-2">New User Request</h1>
    <div class="flex gap-4">
      <p class="text-gray-800 dark:text-gray-300 text-lg">Permintaan user baru / staging user</p>
      <p v-on:click="loadData()" class="text-blue-400 cursor-pointer">refresh data</p>
    </div>
    <table class="table-fixed">
        <thead class="text-gray-900 dark:text-gray-200 text-xl text-bold">
          <tr>
            <th class="border border-green-600 dark:text-gray-300 p-2">No</th>
            <th class="border border-green-600 dark:text-gray-300 p-2">User</th>
            <th class="border border-green-600 dark:text-gray-300 p-2">Real Name</th>
            <th class="border border-green-600 dark:text-gray-300 p-2">Email</th>
            <th class="border border-green-600 dark:text-gray-300 p-2">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, index) in users" :key="user.id">
            <td class="border border-green-600 dark:text-gray-300 p-2">{{ index + 1 }}</td>
            <td class="border border-green-600 dark:text-gray-300 p-2">{{ user.user }}</td>
            <td class="border border-green-600 dark:text-gray-300 p-2">{{ user.disp_name }}</td>
            <td class="border border-green-600 dark:text-gray-300 p-2">{{ user.email }}</td>
            <td class="border border-green-600 dark:text-gray-300 p-2 flex gap-2">
            <button v-on:click="accept(user.id)" class="text-gray-100 bg-lime-600 p-2 ring-1 ring-blue-500 rounded-md">Accept</button>
            <button v-on:click="delice(user.id)" class="text-gray-100 bg-rose-600 p-2 ring-1 ring-blue-500 rounded-md">Delice</button>
            </td>
          </tr>
        </tbody>
    </table>
  </div>
</template>
<script>
export default {
  data() {
    return {
      users: Array()
    }
  },
  methods: {
    loadData: function() {
      fetch('/api/ver1.1/User-Register/request.json')
      .then(response => response.json())
      .then(json => {
        this.users = json.data
        console.log(json.data)
      });
    },
    accept: function(id) {
      fetch(`/api/ver1.1/User-Register/acceptUser.json?user_id=${id}`)
      .then(response => response.json())
      .then(json => {
        if (json.status == 'ok') {
          // success then refresh data
          this.loadData()
        }
      });
    },
    delice: function(id) {
      fetch(`/api/ver1.1/User-Register/declineUser.json?user_id=${id}`)
      .then(response => response.json())
      .then(json => {
        if (json.status == 'ok') {
          // success then refresh data
          this.loadData()
        }
      });
    }
  },
  mounted() {
    this.loadData()
  },
}
</script>
