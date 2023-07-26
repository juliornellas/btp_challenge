<script>
import Table from "@/components/UI/Table.vue";
import { useUsersStore } from "@/stores/users";

export default {
  components: {
    Table,
  },

  setup() {
    const store = useUsersStore();

    const users = store.usersWeather;

    return {
      users,
    };
  },
};
</script>
<template>
  <Table :users="users"></Table>
</template>
