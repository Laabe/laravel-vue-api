<script setup>
import { ref, onMounted } from "vue";
import useUsers from "../../composable/users";
import useGroups from "../../composable/groups";

const { storeUser, errors } = useUsers();
const { getGroups, groups } = useGroups();

const form = ref({
  first_name: "",
  last_name: "",
  email: "",
  phone: "",
  groups_id: "",
});

onMounted(() => {
  getGroups();
});

const saveUser = async () => {
  try {
    await storeUser(form.value);
  } catch (e) {
    errors.value = e.response.data.errors;
  }
};
</script>

<template>
  <div class="card shadow">
    <div class="card-header">
      <h3 class="card-title">Create a new user</h3>
    </div>
    <div class="card-body">
      <form @submit.prevent="saveUser">
        <div class="row">
          <div class="mb-3 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="first_name" class="form-label">First name:</label>
            <input
              type="text"
              name="first_name"
              id="first_name"
              class="form-control"
              placeholder="Enter user first name..."
              v-model="form.first_name"
            />
            <small v-show="errors.first_name">
              <strong class="text-danger">{{ errors.first_name }}</strong>
            </small>
          </div>

          <div class="mb-3 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="last_name" class="form-label">Last name:</label>
            <input
              type="text"
              name="last_name"
              id="last_name"
              class="form-control"
              placeholder="Enter user last name..."
              v-model="form.last_name"
            />
            <small v-show="errors.last_name">
              <strong class="text-danger">{{ errors.last_name }}</strong>
            </small>
          </div>
        </div>

        <div class="row">
          <div class="mb-3 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="email" class="form-label">Email:</label>
            <input
              type="email"
              name="email"
              id="email"
              class="form-control"
              placeholder="Enter email..."
              v-model="form.email"
            />
            <small v-show="errors.email">
              <strong class="text-danger">{{ errors.email }}</strong>
            </small>
          </div>

          <div class="mb-3 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <label for="phone" class="form-label">Phone:</label>
            <input
              type="text"
              name="phone"
              id="phone"
              class="form-control"
              placeholder="Enter phone..."
              v-model="form.phone"
            />
            <small v-show="errors.phone">
              <strong class="text-danger">{{ errors.phone }}</strong>
            </small>
          </div>
        </div>

        <div class="mb-3">
          <button class="btn btn-primary" type="submit">Save</button>
          <router-link :to="{ name: 'users.index' }" class="btn btn-secondary"
            >Cancel</router-link
          >
        </div>
      </form>
    </div>
  </div>
</template>
