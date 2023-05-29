<script setup>
import { onMounted } from "vue";
import useUsers from "../../composable/users";

const { user, getUser, updateUser, errors } = useUsers();

const props = defineProps({
  id: {
    type: String,
    required: true,
  },
});

onMounted(() => {
  getUser(props.id);
});

const saveUser = async () => {
  try {
    await updateUser(props.id);
  } catch (e) {
    errors.value = e.response.data.errors;
  }
};
</script>

<template>
  <div class="card shadow">
    <div class="card-header">
      <h3 class="card-title">Edit user</h3>
    </div>
    <div class="card-body">
      <form @submit.prevent="saveUser">
        <div class="mb-3">
          <label for="first_name" class="form-label">First name:</label>
          <input
            type="text"
            name="first_name"
            id="first_name"
            class="form-control"
            placeholder="Enter user first name..."
            v-model="user.first_name"
          />
          <small v-show="errors.first_name">
            <strong class="text-danger">{{ errors.first_name }}</strong>
          </small>
        </div>

        <div class="mb-3">
          <label for="last_name" class="form-label">Last name:</label>
          <input
            type="text"
            name="last_name"
            id="last_name"
            class="form-control"
            placeholder="Enter user last name..."
            v-model="user.last_name"
          />
          <small v-show="errors.last_name">
            <strong class="text-danger">{{ errors.last_name }}</strong>
          </small>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email:</label>
          <input
            type="email"
            name="email"
            id="email"
            class="form-control"
            placeholder="Enter email..."
            v-model="user.email"
          />
          <small v-show="errors.email">
            <strong class="text-danger">{{ errors.email }}</strong>
          </small>
        </div>

        <div class="mb-3">
          <label for="phone" class="form-label">Phone:</label>
          <input
            type="text"
            name="phone"
            id="phone"
            class="form-control"
            placeholder="Enter phone..."
            v-model="user.phone"
          />
          <small v-show="errors.phone">
            <strong class="text-danger">{{ errors.phone }}</strong>
          </small>
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
