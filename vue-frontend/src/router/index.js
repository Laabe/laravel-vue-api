import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: () => import("../components/HomeView.vue"),
    },
    {
      path: "/groups",
      name: "groups.index",
      component: () => import("../components/groups/GroupIndex.vue"),
    },
    {
      path: "/groups/create",
      name: "groups.create",
      component: () => import("../components/groups/GroupCreate.vue"),
    },
    {
      path: "/groups/:id/edit",
      name: "groups.edit",
      component: () => import("../components/groups/GroupEdit.vue"),
      props: true,
    },
    {
      path: "/groups/:id",
      name: "groups.show",
      component: () => import("../components/groups/GroupShow.vue"),
      props: true,
    },
    {
      path: "/users",
      name: "users.index",
      component: () => import("../components/users/UserIndex.vue"),
    },
    {
      path: "/users/create",
      name: "users.create",
      component: () => import("../components/users/UserCreate.vue"),
    },
    {
      path: "/users/:id/edit",
      name: "users.edit",
      component: () => import("../components/users/UserEdit.vue"),
      props: true,
    },
    {
      path: "/users/:id",
      name: "users.show",
      component: () => import("../components/users/UserShow.vue"),
      props: true,
    },
    {
      path: "/login",
      name: "login",
      component: () => import("../components/auth/Login.vue"),
    },
  ],
});

export default router;
