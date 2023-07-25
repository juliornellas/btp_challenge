import { createRouter, createWebHistory } from "vue-router";
import LandingPage from "@/views/users/Index.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "landing-page",
      component: LandingPage,
    },
    {
      path: "/details/:name/:email/:latitude/:longitude",
      name: "user-details",
      component: () => import("@/views/users/details/Index.vue"),
      props: true,
    },
  ],
});

export default router;
