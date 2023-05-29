<script setup>
import useUsers from "../../composable/users";
import { onMounted, ref, watch } from "vue";
import Pagination from "../Pagination.vue";
import axios from "axios";

const { users, getUsers, destroyUser, totalPages } = useUsers();
const currentPage = ref(1);

onMounted(() => {
  getToken();
  getUsers();
});

const getToken = async () => {
  await axios.get("http://127.0.0.1:8000/sanctum/csrf-cookie");
};

const handlePageChange = (page) => {
  currentPage.value = page;
};

watch(currentPage, (newPage) => {
  getToken();
  getUsers(newPage);
});

const deleteUser = async (id) => {
  if (!window.confirm("Are you sure ?")) {
    return;
  }

  await destroyUser(id);
  await getUsers();
};
</script>

<template>
  <div class="card shadow">
    <div class="card-header d-flex justify-content-between">
      <h3 class="card-title">List of users</h3>
      <router-link :to="{ name: 'users.create' }" class="btn btn-primary"
        >Create user</router-link
      >
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover table-striped">
          <thead>
            <tr>
              <th>FIRST NAME</th>
              <th>LAST NAME</th>
              <th>EMAIL</th>
              <th>PHONE</th>
              <th>GROUPS</th>
              <th>ACTION</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users.data" :key="user.id">
              <td>{{ user.first_name }}</td>
              <td>{{ user.last_name }}</td>
              <td>{{ user.email }}</td>
              <td>{{ user.phone }}</td>
              <td>{{ user.groups.length }}</td>
              <td>
                <router-link
                  :to="{ name: 'users.show', params: { id: user.id } }"
                  class="btn btn-sm btn-dark me-1"
                  >Details</router-link
                >
                <router-link
                  :to="{ name: 'users.edit', params: { id: user.id } }"
                  class="btn btn-sm btn-dark me-1"
                  >Edit</router-link
                >
                <button
                  class="btn btn-sm btn-dark"
                  @click="deleteUser(user.id)"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer">
      <pagination
        :current-page="currentPage"
        :total-pages="totalPages"
        :on-page-change="handlePageChange"
      ></pagination>
    </div>
  </div>
</template>
