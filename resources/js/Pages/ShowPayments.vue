<script setup lang="ts">
import { format } from 'date-fns';
import { router } from '@inertiajs/vue3';
import { computed, defineProps, ref } from 'vue';
import BackButton from '../components/BackButton.vue';
import type { Payment } from '../types/payment';
import type { Player } from '../types/player';

const props = defineProps<{
  payment: Payment;
  players: Player[];
  flash?: string;
}>();


const paymentState = ref({ ...props.payment });

const formatDate = (dateString) => {
  if (!dateString) return '';
  return format(new Date(dateString), 'dd/MM/yyyy');
};

const playersState = ref(
  props.players.map((player) => ({
    id: player.id,
    player_name: player.player_name,
    paid: !!player.pivot?.paid,
  }))
);

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
  const payload = {
    _method: 'PUT',
    court_hours: paymentState.value.court_hours,
    court_rate: paymentState.value.court_rate,
    shuttle_num: paymentState.value.shuttle_num,
    shuttle_rate: paymentState.value.shuttle_rate,
    total_cost: paymentState.value.total_cost,
    payment_per_person: paymentState.value.payment_per_person,
    players: formattedPlayers.value, 
  };

  router.post(`/payments/${props.payment.id}`, payload, {
    onSuccess: () => console.log("Payment updated successfully"),
    onError: (errors) => console.error("Error updating payment:", errors),
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

const removePlayer = (playerId: number) => {
    playersState.value = playersState.value.filter(p => p.id !== playerId);
    updateTotals();
  };

const updateTotals = () => {

    const numPlayers = playersState.value.length;
    
    if (numPlayers === 0) {
      paymentState.value.total_cost = 0;
      paymentState.value.payment_per_person = 0;
      return;
    }
    
    const courtHours = Number(paymentState.value.court_hours) || 0;
    const courtRate = Number(paymentState.value.court_rate) || 0;
    const shuttleNum = Number(paymentState.value.shuttle_num) || 0;
    const shuttleRate = Number(paymentState.value.shuttle_rate) || 0;

    const courtCost = courtHours * courtRate;
    const shuttleCost = shuttleNum * shuttleRate;
    const totalCost = courtCost + shuttleCost;


    paymentState.value = {
      ...paymentState.value,
      total_cost: totalCost,
      payment_per_person: totalCost / numPlayers,
    };
  };


</script>

<template>
  <div class="w-full max-w-2xl mx-auto p-8 mt-10 bg-white shadow-lg rounded-xl">

    <BackButton />


    <h1 class="text-3xl font-bold text-gray-800 text-center mt-4">Payment Details</h1>
    <h2 class="text-lg text-gray-600 text-center mt-2">Date: {{ formatDate(props.payment.date) }}</h2>


    <div v-if="flash" class="bg-green-500 text-white p-3 mt-4 rounded-md text-center">
      {{ flash }}
    </div>


    <form @submit.prevent="updatePayment" class="mt-6 space-y-4">

      <div class="grid grid-cols-2 gap-6">
        <div class="bg-green-100 p-4 rounded-lg">
          <h3 class="text-lg font-semibold text-gray-700 text-center mb-2">Court Fees</h3>
          <div class="flex flex-col space-y-2">
            <label class="text-sm font-medium text-gray-600">Court Hours</label>
            <input type="number" v-model="paymentState.court_hours" class="input-field">
            
            <label class="text-sm font-medium text-gray-600">Court Rate</label>
            <input type="number" v-model="paymentState.court_rate" class="input-field">
          </div>
        </div>

        <div class="bg-green-100 p-4 rounded-lg">
          <h3 class="text-lg font-semibold text-gray-700 text-center mb-2">Shuttle Fees</h3>
          <div class="flex flex-col space-y-2">
            <label class="text-sm font-medium text-gray-600">Shuttles Used</label>
            <input type="number" v-model="paymentState.shuttle_num" class="input-field">
            
            <label class="text-sm font-medium text-gray-600">Price per Shuttle</label>
            <input type="number" v-model="paymentState.shuttle_rate" class="input-field">
          </div>
        </div>
      </div>


      <div class="bg-green-100 p-4 rounded-lg">
        <h3 class="text-lg font-semibold text-gray-700 text-center mb-2">Total Cost</h3>
        <div class="flex flex-col space-y-2">
          <label class="text-sm font-medium text-gray-600">Total Cost</label>
          <input type="number" v-model="props.payment.total_cost" class="input-field" disabled>
          <label class="text-sm font-medium text-gray-600">Payment Per Person</label>
          <input type="number" v-model="props.payment.payment_per_person" class="input-field" disabled>
        </div>
      </div>


      <div v-if="playersState.length" class="bg-green-100 p-4 rounded-lg">
        <h3 class="text-lg font-semibold text-gray-700 text-center mb-2">Players</h3>
        <div class="grid grid-cols-2 gap-3">
          <div v-for="player in playersState" :key="player.id" class="flex items-center justify-between p-2 bg-white rounded-md shadow-sm">
            <div class="flex items-center space-x-3">
              <input type="checkbox" :checked="player.paid" @change="togglePaid(player.id)" class="form-checkbox text-green-500">
              <span class="text-gray-700">{{ player.player_name }}</span>
            </div>
            <button @click="removePlayer(player.id)" class="text-red-500 hover:text-red-700 transition">
              ✖ Remove
            </button>
          </div>
        </div>
      </div>


      <div class="flex justify-between mt-6 gap-2">
        <button type="submit" class="w-1/2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
          Update Payment
        </button>
        <button @click="deletePayment(payment.id)" type="button" class="w-1/2 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 rounded-lg transition">
          Delete Session
        </button>
      </div>
    </form>
  </div>
</template>

<style scoped>
.input-field {
  @apply w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-400 focus:outline-none;
}
</style>
