<script>
import { useUsersStore } from "@/stores/users";
import { useRoute } from "vue-router";
import { computed, ref } from "vue";

export default {
  setup() {
    const route = useRoute();
    const store = useUsersStore();

    const { name, email, latitude, longitude } = route.params;

    store.getWeather(email, latitude, longitude);

    const weather = ref(store.userWeather);

    const date = computed(() => {
      let dt = new Date(weather?.value.dt * 1000);
      let day = dt.getDate();
      let month = dt.getMonth() + 1;
      let year = dt.getFullYear();
      let utc = dt.getUTCHours();

      return `${day}/${month}/${year} - UTC: ${utc}`;
    });
    const sunrise = computed(
      () =>
        new Date(weather?.value?.sys.sunrise * 1000)
          .toTimeString()
          .split(" ")[0]
    );
    const sunset = computed(
      () =>
        new Date(weather?.value?.sys.sunset * 1000).toTimeString().split(" ")[0]
    );
    const icon = computed(
      () =>
        `http://openweathermap.org/img/wn/${weather?.value?.weather[0].icon}@4x.png`
    );
    const iconDescriprion = computed(
      () => weather?.value?.weather[0].description
    );

    return {
      icon,
      iconDescriprion,
      name,
      email,
      date,
      sunrise,
      sunset,
      weather,
    };
  },
};
</script>
<template>
  <div>
    <div class="text-xl text-center my-4 font-bold">User's weather</div>
    <div class="text-center border rounded mx-4">
      <div class="py-4 bg-slate-100 w-full">
        <span class="font-bold text-indigo-800 dark:text-indigo-200">
          {{ name }}
        </span>
        <span class="ml-2 text-sm italic text-gray-400 dark:text-gray-100">
          ({{ email }})
        </span>
      </div>
      <div class="flex justify-around">
        <div class="mt-4">
          <p class="text-slate-900 dark:text-slate-200">Date {{ date }}</p>
          <img :src="icon" :alt="iconDescriprion" />
          <p class="pb-6 font-bold text-indigo-800 dark:text-indigo-200">
            {{ weather?.weather[0].main }}
          </p>
        </div>
        <div class="text-left mt-4">
          <div>
            <p>
              <span class="italic text-red-800 dark:text-red-200"> High </span>
              &nbsp;{{ weather?.main.temp_max }}&deg;C
              <br />
              <span class="italic text-blue-800 dark:text-blue-200"> Low </span>
              &nbsp;{{ weather?.main.temp_min }}&deg;C
              <br />
              High Feels like {{ weather.main.feels_like }}&deg;C
            </p>
            <p class="my-2"></p>
            <p>Pressure {{ weather?.main.pressure }}mb</p>
            <p class="my-2">Humidity {{ weather?.main.humidity }}%</p>
            <p>
              Wind {{ weather?.wind.speed }}m/s, {{ weather?.wind.deg }}&deg;
            </p>
            <p class="mt-2">
              <span class="text-red-800 dark:text-red-200"> Sunrise </span>
              {{ sunrise }}
            </p>
            <p>
              <span class="text-blue-800 dark:text-blue-200"> Sunset </span>
              {{ sunset }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
