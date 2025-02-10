<script setup>
import { ref } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import PlayerModal from "../components/SelectPlayers.vue";  
import BackButton from "../components/BackButton.vue";

const form = useForm({
  court_hours: 1,
  court_rate: 500,
  shuttle_num: 1,
  shuttle_rate: 100,
  players: [], 
});

const showPlayerModal = ref(false);
const selectedPlayers = ref([]);

const goBack = () => {
  router.visit("/");
};


const openPlayerModal = () => {
  showPlayerModal.value = true;
};


const addPlayer = (players) => {
  selectedPlayers.value = players;
  form.players = players.map(player => player.id); 
};

const removePlayer = (playerId) => {
  selectedPlayers.value = selectedPlayers.value.filter((p) => p.id !== playerId);
  form.players = form.players.filter((id) => id !== playerId);
};

const submitForm = () => {
  if (form.players.length === 0) {
    alert("Please select at least one player.");
    return;
  }

  form.post("/payments", {
    onSuccess: () => {
      console.log("Payment created successfully!");
    },
    onError: (errors) => {
      console.error("Error submitting payment:", errors);
    },
  });
};
</script>

<template>
  <div class="max-w-3xl mx-auto my-12 p-8 bg-white shadow-lg rounded-xl">

    <BackButton />

    <h1 class="text-3xl font-bold text-green-700 text-center my-6">Session Details</h1>

    <form @submit.prevent="submitForm" class="grid grid-cols-1 md:grid-cols-2 gap-6">

      <div class="p-5 bg-green-200 rounded-lg shadow-sm">
        <h2 class="text-xl font-semibold text-green-800 text-center mb-4">🏸 Court Fees</h2>
        <div class="flex flex-col gap-3">
          <label for="court_hours" class="text-sm font-semibold">Court Hours</label>
          <input min="0" v-model="form.court_hours" class="border p-2 rounded-lg text-center focus:ring-2 focus:ring-green-400" type="number">

          <label for="court_rate" class="text-sm font-semibold">Rate per Hour</label>
          <input min="0" v-model="form.court_rate" class="border p-2 rounded-lg text-center focus:ring-2 focus:ring-green-400" type="number">
        </div>
      </div>


      <div class="p-5 bg-green-200 rounded-lg shadow-sm">
        <h2 class="text-xl font-semibold text-green-800 text-center mb-4">🏸 Shuttlecock Fees</h2>
        <div class="flex flex-col gap-3">
          <label for="shuttle_num" class="text-sm font-semibold">Shuttles Used</label>
          <input min="0" v-model="form.shuttle_num" class="border p-2 rounded-lg text-center focus:ring-2 focus:ring-green-400" type="number">

          <label for="shuttle_rate" class="text-sm font-semibold">Price per Shuttle</label>
          <input min="0" v-model="form.shuttle_rate" class="border p-2 rounded-lg text-center focus:ring-2 focus:ring-green-400" type="number">
        </div>
      </div>


      <div class="md:col-span-2 p-5 bg-green-200 rounded-lg shadow-sm">
        <h2 class="text-xl font-semibold text-green-800 text-center mb-4">👥 Players</h2>
        
        <div class="flex justify-center">
          <button type="button" @click="openPlayerModal" class="bg-green-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700 transition">
            ➕ Select Players
          </button>
        </div>


        <div v-if="selectedPlayers.length" class="mt-4 bg-white p-4 rounded-lg shadow-sm">
          <h3 class="text-lg font-semibold text-green-700 mb-2">Selected Players:</h3>
          <ul class="divide-y divide-gray-200">
            <li v-for="player in selectedPlayers" :key="player.id" class="flex justify-between items-center py-2">
              <span class="text-gray-800">{{ player.player_name }}</span>
              <button @click="removePlayer(player.id)" class="text-red-500 hover:text-red-700 transition">✖ Remove</button>
            </li>
          </ul>
        </div>
      </div>

  
      <div class="md:col-span-2 flex justify-center">
        <button type="submit" class="bg-green-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-green-700 transition">
          ✅ Create Payment
        </button>
      </div>
    </form>


    <PlayerModal v-if="showPlayerModal" @close="showPlayerModal = false" @add-player="addPlayer" />
  </div>
</template>
