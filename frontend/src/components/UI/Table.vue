<script lang="ts">
export default {
  props: {
    users: {
      type: Array,
      required: true,
    },
  },
};
</script>
<template>
  <table
    class="border-collapse border border-slate-400 w-full dark:border-slate-500 bg-white dark:bg-slate-800 text-sm shadow-sm"
  >
    <thead class="bg-slate-50 dark:bg-slate-700">
      <tr>
        <th
          class="border border-slate-300 font-semibold text-slate-900 text-left dark:text-slate-200 dark:border-slate-600 p-2"
        >
          Name
        </th>
        <th
          class="border border-slate-300 font-semibold text-slate-900 text-left dark:text-slate-200 dark:border-slate-600 p-2"
        >
          Email
        </th>
        <th
          class="border border-slate-300 font-semibold text-slate-900 text-left dark:text-slate-200 dark:border-slate-600 p-2"
        >
          Latitude
        </th>
        <th
          class="border border-slate-300 font-semibold text-slate-900 text-left dark:text-slate-200 dark:border-slate-600 p-2"
        >
          Longitude
        </th>
      </tr>
    </thead>
    <tbody>
      <tr
        class="hover:bg-slate-100"
        v-for="{ id, name, email, emailVerified, latitude, longitude } in users"
        :key="email"
      >
        <td
          class="border border-slate-300 dark:border-slate-700 p-2 text-slate-500 dark:text-slate-400"
        >
          <RouterLink
            :to="{
              name: 'user-details',
              params: { name, email, latitude, longitude },
            }"
          >
            {{ name }}
          </RouterLink>
        </td>
        <td
          class="border border-slate-300 dark:border-slate-700 p-2 text-slate-500 dark:text-slate-400"
        >
          {{ email }}
        </td>
        <td
          class="border border-slate-300 dark:border-slate-700 p-2 text-slate-500 dark:text-slate-400"
        >
          {{ latitude }}
        </td>
        <td
          class="border border-slate-300 dark:border-slate-700 p-2 text-slate-500 dark:text-slate-400"
        >
          {{ longitude }}
        </td>
      </tr>
    </tbody>
  </table>
</template>
