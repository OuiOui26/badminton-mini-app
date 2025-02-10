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
  <div class="flex flex-col p-10 justify-center rounded-xl items-center bg-green-400 w-[50%] mx-auto my-10">
    <h1 class="text-2xl font-bold text-white">Badminton Payment Tracker</h1>

    <div class="grid grid-cols-2 gap-2 mt-5">
      <button @click="goToCreatePayments" class="bg-white text-green-600 font-bold py-2 px-4 rounded-lg hover:bg-gray-200">
        Create New Session
      </button>
      <button @click="showAllPayments" class="bg-white text-green-600 font-bold py-2 px-4 rounded-lg hover:bg-gray-200">
        Show All Sessions
      </button>

      <button @click="goToPlayersListPage" class="bg-white col-span-2 text-green-600 font-bold py-2 px-4 rounded-lg hover:bg-gray-200">
        Show All Players
      </button>
    </div>
  </div>
</template>