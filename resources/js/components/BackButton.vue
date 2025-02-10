<script setup lang="ts">

const goBack = () => {
  window.history.back();
};
</script>

<template>
  <button 
    @click="goBack" 
    class="flex items-center gap-2 border border-1 text-green-600 font-bold py-2 px-4 rounded-lg hover:bg-green-100 transition"
  >
    ⬅ Back
  </button>
</template>
