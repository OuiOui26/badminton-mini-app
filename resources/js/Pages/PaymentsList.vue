<script setup lang="ts">
import { defineProps, ref } from 'vue';
import type { Payment } from '../types/payment';
import { router } from '@inertiajs/vue3';
import { format } from 'date-fns';
import BackButton from '../components/BackButton.vue';

const props = defineProps<{ payments: Payment[] }>();

const payments = ref(props.payments);

const goBack = () => {
  router.visit('/');
};

const formatDate = (dateString) => {
  if (!dateString) return '';
  return format(new Date(dateString), 'dd/MM/yyyy');
};

const showPayment = (id) => {
    router.visit(`/payments/${id}`);
};




</script>

<template>
    <div class="max-w-3xl mx-auto my-12 p-8 bg-white shadow-lg rounded-xl">
      <BackButton />
  
    <h1 class="text-3xl font-bold text-green-700 text-center my-2">Payment List</h1>
  
      <div class="grid grid-cols-2 gap-2 p-4">
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
          
          <button @click="showPayment(payment.id)" class="w-full bg-white rounded-lg text-green-600 font-bold p-2 mt-4">View Session</button>
        </div>
      </div>
    </div>
  </template>
