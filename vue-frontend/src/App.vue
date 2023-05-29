<script setup>
import { RouterLink, RouterView } from "vue-router";
import Nav from "./components/Nav.vue";
</script>

<template>
  <Nav />
  <div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <RouterView />
      </div>
    </div>
  </div>
</template>

<style scoped></style>
