<template>
    <div class="w-1/2 mx-auto p-5 pt-10 mt-10 flex flex-col items-center  bg-white shadow-md rounded-lg">
      <h1 class="text-2xl font-bold text-gray-800">Payment Details</h1>
      
      <div v-if="flash" class="bg-green-500 text-white p-2 mt-4 rounded-md">
        {{ flash }}
      </div>
  
      <div class="mt-5">
        <p><strong>Court Hours:</strong> {{ payment.data.court_hours }}</p>
        <p><strong>Court Rate:</strong> {{ payment.data.court_rate }}</p>
        <p><strong>Shuttle Num:</strong> {{ payment.data.shuttle_num }}</p>
        <p><strong>Shuttle Rate:</strong> {{ payment.data.shuttle_rate }}</p>
        <p><strong>Total Cost:</strong> {{ payment.data.total_cost }}</p>
        <p><strong>Payment Per Person:</strong> {{ payment.data.payment_per_person }}</p>
      </div>
  
      <button @click="goBack" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md">Back</button>
    </div>
  </template>
  
  <script setup>
  import { defineProps } from 'vue';
  import { router } from '@inertiajs/vue3';
  
  const props = defineProps(['payment', 'flash']);
  const goBack = () => {
    router.visit('/payments');
  };

  </script>
  