import { defineStore } from "pinia";
import { computed, ref } from "vue";

export const useUsersStore = defineStore("users", () => {
  //State
  const users = ref([]);
  const user = ref([]);

  //Getters
  const usersWeather = computed(() => users);
  const userWeather = computed(() => user);

  const url = "http://localhost:8000/";
  (async function getUsers() {
    const apiResponse = await fetch(url);
    const res = await apiResponse.json();
    users.value = res.users;
  })();

  async function getWeather(
    email: string,
    latitude: string,
    longitude: string
  ) {
    let u = `${url}get-user-weather/${email}/${latitude}/${longitude}`;
    const apiResponse = await fetch(u);
    const res = await apiResponse.json();
    user.value = res.user;
  }

  return {
    userWeather,
    usersWeather,
    getWeather,
  };
});
