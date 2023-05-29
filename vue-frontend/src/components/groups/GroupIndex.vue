<script setup>
import useGroups from "../../composable/groups";
import { onMounted, ref, watch } from "vue";
import Pagination from "../Pagination.vue";

const { groups, getGroups, destroyGroup, totalPages } = useGroups();
const currentPage = ref(1);

onMounted(() => {
  getGroups();
});

const handlePageChange = (page) => {
  currentPage.value = page;
};

watch(currentPage, (newPage) => {
  getGroups(newPage);
});

const deleteGroup = async (id) => {
  if (!window.confirm("Are you sure ?")) {
    return;
  }

  await destroyGroup(id);
  await getGroups();
};
</script>

<template>
  <div class="card shadow">
    <div class="card-header d-flex justify-content-between">
      <h3 class="card-title">List of groups</h3>
      <router-link :to="{ name: 'groups.create' }" class="btn btn-primary"
        >Create a group</router-link
      >
    </div>
    <div class="card-body">
      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>GROUP NAME</th>
            <th>USERS COUNT</th>
            <th>ACTION</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="group in groups.data" :key="group.id">
            <td>{{ group.id }}</td>
            <td>{{ group.name }}</td>
            <td>{{ group.users.length }}</td>
            <td>
              <router-link
                :to="{ name: 'groups.show', params: { id: group.id } }"
                class="btn btn-sm btn-dark me-1"
                >Details</router-link
              >
              <router-link
                :to="{ name: 'groups.edit', params: { id: group.id } }"
                class="btn btn-sm btn-dark me-1"
                >Edit</router-link
              >
              <button
                role="button"
                class="btn btn-sm btn-dark me-1"
                @click="deleteGroup(group.id)"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
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
