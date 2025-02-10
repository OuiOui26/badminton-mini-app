<script setup lang="ts">
import { defineProps, ref } from 'vue';
import type { Payment } from '../types/payment';
import { router } from '@inertiajs/vue3';

const props = defineProps<{ payments: Payment[] }>();

const payments = ref(props.payments);

const goBack = () => {
  router.visit('/');
};

const formatDate = (dateString) => {
  if (!dateString) return '';
  const date = new Date(dateString);
  return date.toLocaleDateString('en-GB');
};

const showPayment = (id) => {
    router.visit(`/payments/${id}`);
};




</script>

<template>
    <div class="p-5">
      <button @click="goBack" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md">Back</button>
  
      <h1 class="text-xl font-bold">Payments List</h1>
  
      <div class="grid grid-cols-2 gap-2">
        <div v-for="payment in payments" :key="payment.id" class="border p-4 mt-4 bg-green-600 text-white rounded-lg">
          <div class="flex justify-between">
            <h2 class="text-lg font-semibold">Session #{{ payment.id }}</h2>
            <h2 class="text-lg font-semibold">Date : {{ formatDate(payment.date) }}</h2>
          </div>
          <p><strong>Court Hours:</strong> {{ payment.court_hours }}</p>
          <p><strong>Court Rate:</strong> {{ payment.court_rate }}</p>
          <p><strong>Shuttle Num:</strong> {{ payment.shuttle_num }}</p>
          <p><strong>Shuttle Rate:</strong> {{ payment.shuttle_rate }}</p>
          <p><strong>Total Cost:</strong> {{ payment.total_cost }}</p>
          <p><strong>Payment Per Person:</strong> {{ payment.payment_per_person }}</p>
          
          <button @click="showPayment(payment.id)" class="bg-white rounded-lg text-black p-2">View Session</button>
        </div>
      </div>
    </div>
  </template>
