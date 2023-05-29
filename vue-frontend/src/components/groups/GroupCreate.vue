<script setup>
import { ref } from "vue";
import useGroups from "../../composable/groups";

const { storeGroup, errors } = useGroups();

const form = ref({
  name: "",
  description: "",
});

const saveGroup = async () => {
  try {
    await storeGroup(form.value);
  } catch (e) {
    errors.value = e.response.data.errors;
  }
};
</script>

<template>
  <div class="card shadow">
    <div class="card-header">
      <h3 class="card-title">Create a group</h3>
    </div>
    <div class="card-body">
      <form @submit.prevent="saveGroup">
        <div class="mb-3">
          <label for="name" class="form-label">Group Name:</label>
          <input
            type="text"
            name="name"
            id="name"
            class="form-control"
            placeholder="Enter group name..."
            v-model="form.name"
          />
          <small v-show="errors.name">
            <strong class="text-danger">{{ errors.name }}</strong>
          </small>
        </div>

        <div class="mb-3">
          <label for="description" class="form-label">Group Description:</label>
          <textarea
            name="description"
            id="description"
            cols="30"
            rows="10"
            placeholder="Write here..."
            class="form-control"
            v-model="form.description"
          ></textarea>
          <small v-show="errors.description">
            <strong class="text-danger">{{ errors.description }}</strong>
          </small>
        </div>

        <div class="mb-3">
          <button class="btn btn-primary" type="submit">Save</button>
          <router-link :to="{ name: 'groups.index' }" class="btn btn-secondary"
            >Cancel</router-link
          >
        </div>
      </form>
    </div>
  </div>
</template>
