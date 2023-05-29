import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const useGroups = () => {
  const group = ref([]);
  const groups = ref([]);
  const router = useRouter();
  const errors = ref([]);
  const totalPages = ref();

  const getGroup = async (id) => {
    let response = await axios.get("http://127.0.0.1:8000/api/groups/" + id);
    group.value = response.data.data;
  };

  const getGroups = async (page = 1) => {
    let response = await axios.get(
      "http://127.0.0.1:8000/api/groups?page=" + page
    );
    groups.value = response.data;
    totalPages.value = response.data.meta.last_page;
  };

  const storeGroup = async (data) => {
    await axios.post("http://127.0.0.1:8000/api/groups", data);
    await router.push({ name: "groups.index" });
  };

  const updateGroup = async (id) => {
    await axios.put("http://127.0.0.1:8000/api/groups/" + id, group.value);
    await router.push({ name: "groups.index" });
  };

  const destroyGroup = async (id) => {
    await axios.delete("http://127.0.0.1:8000/api/groups/" + id);
  };

  const detacheUser = async (id, userId) => {
    await axios.post(
      "http://127.0.0.1:8000/api/groups/" + id + "/detach-user/" + userId
    );
  };

  const attachUser = async (id, userId) => {
    await axios.post(
      "http://127.0.0.1:8000/api/groups/" + id + "/attach-user/" + userId
    );
  };

  return {
    group,
    groups,
    getGroup,
    getGroups,
    storeGroup,
    updateGroup,
    destroyGroup,
    attachUser,
    detacheUser,
    errors,
    totalPages,
  };
};

export default useGroups;
