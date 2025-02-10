<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import PlayerModal from '@/components/CreatePlayerModal.vue';

const goToCreatePayments = () => {
  router.visit('payments/create');
};
const showAllPayments = () => {
  router.visit('payments');
};

const showCreatePlayerModal = ref(false); 

const openModal = () => {
  showCreatePlayerModal.value = true;
};

const closeModal = () => {
  showCreatePlayerModal.value = false;
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
      
      <button @click="openModal" class="bg-white text-green-600 font-bold py-2 px-4 rounded-lg hover:bg-gray-200">
        Create New Player
      </button>
      <button @click="" class="bg-white text-green-600 font-bold py-2 px-4 rounded-lg hover:bg-gray-200">
        Show Player List
      </button>
    </div>
  </div>
  <PlayerModal :show="showCreatePlayerModal" @close="closeModal" />
</template>