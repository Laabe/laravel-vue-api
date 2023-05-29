<script setup>
import { onMounted, ref } from "vue";
import useUsers from "../../composable/users";
import useGroups from "../../composable/groups";

const { user, getUser, detacheGroup, attachGroup } = useUsers();
const { groups, getGroups } = useGroups();

const props = defineProps({
  id: {
    type: String,
    required: true,
  },
});

const form = ref({
  group: "",
});

onMounted(() => {
  getUser(props.id);
});

const allGroups = async () => {
  await getGroups();
};

const removeGroup = async (id, groupId) => {
  if (!window.confirm("Are you sure ?")) {
    return;
  }

  await detacheGroup(id, groupId);
  await getUser(props.id);
};

const associateGroup = async () => {
  // console.log(form.value.group);
  await attachGroup(props.id, form.value.group);
  await getUser(props.id);
};
</script>

<template>
  <div>
    <div class="card shadow mb-3 bg-dark">
      <div class="card-body text-center text-light">
        <h2>{{ `${user.first_name} ${user.last_name} information` }}</h2>
      </div>
    </div>

    <div class="card shadow mb-3">
      <div class="card-header">
        <h3 class="card-title">Personnal Information</h3>
      </div>
      <div class="card-body">
        <div class="d-flex flex-wrap">
          <div class="col-6">
            <strong>ID: </strong>
            <span>{{ user.id }}</span>
          </div>
          <div class="col-6">
            <strong>Fullname: </strong>
            <span>{{ `${user.first_name} ${user.last_name}` }}</span>
          </div>
          <div class="col-6">
            <strong>Email: </strong>
            <span>{{ user.email }}</span>
          </div>
          <div class="col-6">
            <strong>Phone: </strong>
            <span>{{ user.phone }}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="card shadow">
      <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Group details</h3>
        <button
          class="btn btn-dark"
          data-bs-toggle="modal"
          data-bs-target="#modal"
          @click="allGroups"
        >
          Attach a group
        </button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>GROUP NAME</th>
                <th>ACTION</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(group, index) in user.groups" :key="index">
                <td>{{ group.id }}</td>
                <td>{{ group.name }}</td>
                <td>
                  <button
                    class="btn btn-sm btn-dark"
                    @click="removeGroup(user.id, group.id)"
                  >
                    Dettach
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div
      class="modal fade"
      id="modal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <form @submit.prevent="associateGroup">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Attach a group</h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="group" class="form-label">Group</label>
                <select
                  name="group"
                  id="group"
                  v-model="form.group"
                  class="form-control"
                >
                  <option selected disabled>Select a group</option>
                  <option
                    v-for="group in groups.data"
                    :value="group.id"
                    v-text="group.name"
                  ></option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
              >
                Close
              </button>
              <button type="submit" class="btn btn-primary">
                Save changes
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
