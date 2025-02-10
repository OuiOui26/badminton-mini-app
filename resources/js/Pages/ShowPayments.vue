<script setup lang="ts">
import { computed, defineProps, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import type { Payment } from '../types/payment';
import type { Player } from '../types/player';

const props = defineProps<{
  payment: Payment;
  players: Player[];
  flash?: string;
}>();


const playersState = ref(props.players.map(player => ({
  id: player.id,
  player_name: player.player_name,
  paid: !!player.pivot?.paid 
})));


const goBack = () => {
  router.visit('/payments');
};


const togglePaid = (playerId: number) => {
  const player = playersState.value.find(p => p.id === playerId);
  if (player) {
    player.paid = !player.paid;
  }
};


const formattedPlayers = computed(() => playersState.value.map(player => ({
  id: player.id,
  paid: player.paid
})));


const updatePayment = () => {
  router.post(`/payments/${props.payment.id}`, {
    _method: 'PUT', 
    court_hours: props.payment.court_hours,
    court_rate: props.payment.court_rate,
    shuttle_num: props.payment.shuttle_num,
    shuttle_rate: props.payment.shuttle_rate,
    total_cost: props.payment.total_cost,
    payment_per_person: props.payment.payment_per_person,
    players: formattedPlayers.value,
  });
};

const deletePayment = (id) => {
  if (confirm('Are you sure you want to delete this payment?')) {
    router.post(`/payments/${id}`, {
      _method: 'DELETE', 
    }, {
      preserveState: false, 
      preserveScroll: true,
      onSuccess: () => {
        alert('Payment deleted successfully!');
      },
      onError: (errors) => {
        console.error('Error deleting payment:', errors);
      },
    });
  }
};


</script>

<template>
  <button @click="goBack" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md">Back</button>

  <form @submit.prevent="updatePayment">
    <div class="w-1/2 mx-auto p-5 pt-10 mt-10 flex flex-col items-center bg-white shadow-md rounded-lg">
      <h1 class="text-2xl font-bold text-gray-800">Payment Details</h1>

      <div v-if="flash" class="bg-green-500 text-white p-2 mt-4 rounded-md">
        {{ flash }}
      </div>


      <div class="mt-5">
        <span><strong>Court Hours:</strong></span>
        <input type="text" v-model="props.payment.court_hours" class="pr-4"><br>

        <span><strong>Court Rate:</strong></span>
        <input type="text" v-model="props.payment.court_rate" class="pr-4"><br>

        <span><strong>Shuttle Num:</strong></span>
        <input type="text" v-model="props.payment.shuttle_num" class="pr-4"><br>

        <span><strong>Shuttle Rate:</strong></span>
        <input type="text" v-model="props.payment.shuttle_rate" class="pr-4"><br>

        <span><strong>Total Cost:</strong></span>
        <input type="text" v-model="props.payment.total_cost" class="pr-4"><br>

        <span><strong>Payment Per Person:</strong></span>
        <input type="text" v-model="props.payment.payment_per_person" class="pr-4"><br>
      </div>


      <div v-if="playersState.length" class="grid grid-cols-3 mt-5">
        <div v-for="player in playersState" :key="player.id" class="mb-2">
          <label class="flex items-center space-x-2">
            <input type="checkbox" :checked="player.paid" @change="togglePaid(player.id)">
            <span>{{ player.player_name }}</span>
          </label>
        </div>
      </div>

      <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
    </div>
  </form>
  <button @click="deletePayment(payment.id)" class="bg-red-600 rounded-lg text-white p-2">Delete Session</button>
</template>
