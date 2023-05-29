<script setup>
const props = defineProps({
  currentPage: {
    required: true,
  },
  totalPages: {
    required: true,
  },
  onPageChange: {
    type: Function,
    required: true,
  },
});

const goToPage = async (page) => {
  await props.onPageChange(page);
};
</script>

<template>
  <nav class="mt-2">
    <ul class="pagination justify-content-center">
      <li class="page-item" :class="{ disabled: currentPage === 1 }">
        <a
          class="page-link"
          href="javascript:void(0)"
          @click="goToPage(currentPage - 1)"
          tabindex="-1"
          aria-disabled="true"
          >Previous</a
        >
      </li>
      <li
        v-for="page in totalPages"
        :key="page"
        :class="{ active: page === currentPage }"
        class="page-item"
      >
        <a
          class="page-link"
          @click="goToPage(page)"
          href="javascript:void(0)"
          >{{ page }}</a
        >
      </li>
      <li :class="{ disabled: currentPage === totalPages }" class="page-item">
        <a
          class="page-link"
          @click="goToPage(currentPage + 1)"
          href="javascript:void(0)"
          >Next</a
        >
      </li>
    </ul>
  </nav>
</template>
