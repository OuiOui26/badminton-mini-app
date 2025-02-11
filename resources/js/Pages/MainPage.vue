<script setup>
import { router } from '@inertiajs/vue3';

const goToCreatePayments = () => {
  router.visit('payments/create');
};
const showAllPayments = () => {
  router.visit('payments');
};
const goToPlayersListPage = () => {
  router.visit('/players/show');
};
</script>

<template>
  <div class="flex flex-col p-10 justify-center rounded-2xl items-center bg-gradient-to-br from-green-400 to-green-500 w-full max-w-xl mx-auto mt-36 shadow-lg">
    <h1 class="text-3xl font-extrabold text-white drop-shadow-lg">🏸 Badminton Payment Tracker</h1>

    <div class="grid grid-cols-1 gap-4 mt-6 w-full">
      <button @click="goToCreatePayments" class="btn">
        ➕ Create New Session
      </button>
      <button @click="showAllPayments" class="btn">
        📋 Show All Sessions
      </button>
      <button @click="goToPlayersListPage" class="btn">
        🏅 Show All Players
      </button>
    </div>
  </div>
</template>

<style scoped>
.btn {
  @apply w-full bg-white text-green-700 font-bold py-3 px-6 rounded-lg shadow-md transition-all 
    hover:bg-green-100 hover:shadow-lg flex items-center justify-center gap-2;
}
</style>
