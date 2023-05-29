import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const useUsers = () => {
  const user = ref([]);
  const users = ref([]);
  const router = useRouter();
  const errors = ref([]);
  const totalPages = ref();

  const getUser = async (id) => {
    let response = await axios.get("http://127.0.0.1:8000/api/users/" + id);
    user.value = response.data.data;
  };

  const getUsers = async (page = 1) => {
    let response = await axios.get(
      "http://127.0.0.1:8000/api/users?page=" + page
    );
    users.value = response.data;
    totalPages.value = response.data.meta.last_page;
  };

  const storeUser = async (data) => {
    await axios.post("http://127.0.0.1:8000/api/users", data);
    await router.push({ name: "users.index" });
  };

  const updateUser = async (id) => {
    await axios.put("http://127.0.0.1:8000/api/users/" + id, user.value);
    await router.push({ name: "users.index" });
  };

  const destroyUser = async (id) => {
    await axios.delete("http://127.0.0.1:8000/api/users/" + id);
  };

  const detacheGroup = async (id, groupId) => {
    await axios.post(
      "http://127.0.0.1:8000/api/users/" + id + "/detach-group/" + groupId
    );
  };

  const attachGroup = async (id, groupId) => {
    await axios.post(
      "http://127.0.0.1:8000/api/users/" + id + "/attach-group/" + groupId
    );
  };

  return {
    user,
    users,
    getUser,
    getUsers,
    storeUser,
    updateUser,
    destroyUser,
    attachGroup,
    detacheGroup,
    errors,
    totalPages,
  };
};

export default useUsers;
