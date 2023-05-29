<script setup>
import { onMounted } from "vue";
import useGroups from "../../composable/groups";

const { group, getGroup, detacheUser, attachUser } = useGroups();

const props = defineProps({
  id: {
    type: String,
    required: true,
  },
});

onMounted(() => {
  getGroup(props.id);
});

const removeUser = async (id, userId) => {
  if (!window.confirm("Are you sure ?")) {
    return;
  }

  await detacheUser(id, userId);
  await getGroup(props.id);
};

const associateUser = async (id, userId) => {
  await attachUser(id, userId);
  await getGroup(props.id);
};
</script>

<template>
  <div>
    <div class="card shadow mb-3 bg-dark">
      <div class="card-body text-center text-light">
        <h2>{{ `${group.name} information` }}</h2>
      </div>
    </div>

    <div class="card shadow mb-3">
      <div class="card-header">
        <h3 class="card-title">Personnal Information</h3>
      </div>
      <div class="card-body">
        <div class="d-flex flex-wrap">
          <div class="col-6 mb-3">
            <strong>ID: </strong>
            <span>{{ group.id }}</span>
          </div>
          <div class="col-6 mb-3">
            <strong>Group name: </strong>
            <span>{{ group.name }}</span>
          </div>
          <div class="col-12">
            <strong>Description: </strong>
            <p>{{ group.description }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="card shadow">
      <div class="card-header">
        <h3 class="card-title">Users details</h3>
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
                <th>ACTION</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in group.users" :key="user.id">
                <td>{{ user.first_name }}</td>
                <td>{{ user.last_name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.phone }}</td>
                <td>
                  <button
                    class="btn btn-sm btn-dark"
                    @click="removeUser(group.id, user.id)"
                  >
                    Detach
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
