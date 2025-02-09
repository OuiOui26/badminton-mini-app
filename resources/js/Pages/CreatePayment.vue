<script setup>
import { ref } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import PlayerModal from "../components/SelectPlayers.vue";  

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
  <div class="flex flex-col p-2 justify-center rounded-xl items-center bg-green-400 w-[50%] mx-auto my-10">
    <div class="flex flex-col flex-start w-full">
      <button @click="goBack" class="w-[10%] bg-white text-green-600 font-bold py-2 px-4 rounded-lg hover:bg-gray-200">
        Back
      </button>
    </div>

    <h1 class="text-2xl font-bold text-white">Create New Session</h1>

    <form @submit.prevent="submitForm" class="grid grid-cols-2 gap-4 w-full rounded-xl">
      <div class="flex flex-col p-5">
        <h2 class="bg-green-600 text-white rounded-lg text-center font-semibold py-3">Court Fees</h2>
        <div class="flex flex-col items-center gap-2 pt-2">
          <label for="court_hours">Court Hours</label>
          <input min="0" v-model="form.court_hours" class="rounded-lg text-center" type="number" name="court_hours" id="court_hours">

          <label for="court_rate">Rate of Court</label>
          <input min="0" v-model="form.court_rate" class="rounded-lg text-center" type="number" name="court_rate" id="court_rate">
        </div>
      </div>

      <div class="flex flex-col p-5">
        <h2 class="bg-green-600 text-white rounded-lg text-center font-semibold py-3">Shuttlecock Fees</h2>
        <div class="flex flex-col items-center gap-2 pt-2">
          <label for="shuttle_num">Shuttles Used</label>
          <input min="0" v-model="form.shuttle_num" class="rounded-lg text-center" type="number" name="shuttle_num" id="shuttle_num">

          <label for="shuttle_rate">Price per shuttle</label>
          <input min="0" v-model="form.shuttle_rate" class="rounded-lg text-center" type="number" name="shuttle_rate" id="shuttle_rate">
        </div>
      </div>

    <div class="flex flex-col p-5">
        <h2 class="bg-green-600 text-white rounded-lg text-center font-semibold py-3">Players</h2>
        <div class="flex flex-col items-center gap-2 pt-2">
          <button type="button" @click="openPlayerModal" class="bg-white text-green-600 font-bold px-2 mt-2 rounded-lg hover:bg-gray-200">
            Select Players
          </button>

          <div v-if="selectedPlayers.length" class="mt-4 w-full">
            <h3 class="text-white text-lg font-semibold">Selected Players:</h3>
            <ul class="bg-white p-2 rounded w-full">
              <li v-for="player in selectedPlayers" :key="player.id" class="flex justify-between items-center p-1 border-b">
                <span>{{ player.player_name }}</span>
                <button @click="removePlayer(player.id)" class="text-red-600 text-sm">Remove</button>
              </li>
            </ul>
          </div>

          <button type="submit" class="bg-white text-green-600 font-bold px-2 mt-5 rounded-lg hover:bg-gray-200">
            Create Payment
          </button>
        </div>
      </div>
    </form>
    <PlayerModal v-if="showPlayerModal" @close="showPlayerModal = false" @add-player="addPlayer" />
  </div>
</template>
