<template>
  <div class="flex flex-col p-10 justify-center rounded-xl items-center bg-green-400 w-[50%] mx-auto my-10">
    <h1 class="text-2xl font-bold text-white">Badminton Calculator</h1>

    <form @submit.prevent="submitForm" class="grid grid-cols-2 gap-10 w-full rounded-xl">

      <div class="flex flex-col p-5">    
        <h2 class="bg-green-600 text-white rounded-lg text-center font-semibold py-3">Court Fees</h2>
        <div class="flex flex-col items-center gap-2 pt-2">
          <label for="court_num">Number of Courts</label>
          <input v-model="form.court_num" class="rounded-lg text-center" type="number" name="court_num" id="court_num">
          
          <label for="court_rate">Rate of Court</label>
          <input v-model="form.court_rate" class="rounded-lg text-center" type="number" name="court_rate" id="court_rate">
        </div>
      </div>  

      <div class="flex flex-col p-5">    
        <h2 class="bg-green-600 text-white rounded-lg text-center font-semibold py-3">Shuttlecock Fees</h2>
        <div class="flex flex-col items-center gap-2 pt-2">
          <label for="shuttle_num">Shuttles Used</label>
          <input v-model="form.shuttle_num" class="rounded-lg text-center" type="number" name="shuttle_num" id="shuttle_num">
          
          <label for="shuttle_rate">Price per shuttle</label>
          <input v-model="form.shuttle_rate" class="rounded-lg text-center" type="number" name="shuttle_rate" id="shuttle_rate">
        </div>
      </div>  
    </form>
    
    <div class="flex flex-col mt-5">    
      <h2 class="bg-green-600 text-white rounded-lg text-center font-semibold px-2 py-1">Number of Players</h2>
      <input v-model="form.players" class="rounded-lg text-center mt-2" type="number" name="players" id="players">
    </div>  

    <button @click="submitForm" class="bg-white text-green-600 font-bold py-2 px-4 mt-5 rounded-lg hover:bg-gray-200">
      Calculate Payment
    </button>

    <div v-if="totalPayment !== null" class="mt-5 p-4 bg-white text-center rounded-lg shadow-md">
      <h2 class="text-lg font-semibold">Total Payment Per Person:</h2>
      <p class="text-xl font-bold">{{ totalPayment }}</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const form = ref({
  court_num: 1,
  court_rate: 500,
  shuttle_num: 1,
  shuttle_rate: 100,
  players: 4
});

const totalPayment = ref(null);

const submitForm = async () => {
  try {
    const response = await axios.post("/api/payments", form.value);
    totalPayment.value = response.data.payment_per_person;
  } catch (error) {
    console.error("Error calculating payment:", error);
  }
};

onMounted(() => {
  document.title = "Badminton Calculator";
});
</script>
