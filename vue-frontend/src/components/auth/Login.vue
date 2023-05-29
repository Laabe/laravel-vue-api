<script setup>
import axios from "axios";
import { ref } from "vue";
import { useRouter } from "vue-router";

axios.defaults.withCredentials = true;

const router = useRouter();

const form = ref({
  email: "",
  password: "",
});

const errors = ref([]);

const getToken = async () => {
  await axios.get("http://127.0.0.1:8000/sanctum/csrf-cookie");
};

const login = async () => {
  try {
    getToken();
    let response = await axios.post("http://127.0.0.1:8000/login", form.value);
    router.push({ name: "users.index" });
  } catch (e) {
    errors.value = e.response.data.errors;
  }
};
</script>

<template>
  <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow col-xl-6 col-lg-6 col-md-12 col-sm-12">
      <div class="card-body">
        <div class="display-2 text-center mb-5">Login</div>

        <form @submit.prevent="login">
          <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input
              type="email"
              name="email"
              id="email"
              class="form-control"
              placeholder="Enter email..."
              v-model="form.email"
            />
            <small v-show="errors.email" class="text-danger">
              <strong>{{ errors.email }}</strong>
            </small>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input
              type="password"
              name="password"
              id="password"
              class="form-control"
              placeholder="Enter password..."
              v-model="form.password"
            />
          </div>

          <div class="mb-3">
            <button class="btn btn-dark btn-block">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
