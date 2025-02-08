<script setup>

import { useForm } from '@inertiajs/vue3'

const form = useForm({
  court_hours: 1,
  court_rate: 500,
  shuttle_num: 1,
  shuttle_rate: 100,
  players: 4
})

const submitForm = () => {
  form.post('/payments', {
    onSuccess: () => {
      console.log('Redirected successfully!')
    },
    onError: (errors) => {
      console.error('Error submitting payment:', errors)
    }
  })
}
</script>


<template>
  <div class="flex flex-col p-10 justify-center rounded-xl items-center bg-green-400 w-[50%] mx-auto my-10">
    <h1 class="text-2xl font-bold text-white">Badminton Calculator</h1>

    <form @submit.prevent="submitForm" class="grid grid-cols-2 gap-10 w-full rounded-xl">

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
    </form>
    
    <div class="flex flex-col mt-5">    
      <h2 class="bg-green-600 text-white rounded-lg text-center font-semibold px-2 py-1">Number of Players</h2>
      <input min="0" v-model="form.players" class="rounded-lg text-center mt-2" type="number" name="players" id="players">
    </div>  

    <button @click="submitForm" class="bg-white text-green-600 font-bold py-2 px-4 mt-5 rounded-lg hover:bg-gray-200">
      Calculate Payment
    </button>

  </div>
</template>


