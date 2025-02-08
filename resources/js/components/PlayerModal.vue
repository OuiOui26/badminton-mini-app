<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineProps, defineEmits, watch } from 'vue';

const props = defineProps({
  show: Boolean, 
});

const emit = defineEmits(['close']);

const form = useForm({
  player_name: '',
});

const submitForm = () => {
  form.post('/players', {
    onSuccess: () => {
      form.reset(); 
      emit('close'); 
    },
    onError: (errors) => {
      console.error('Error submitting player:', errors);
    },
  });
};

watch(() => props.show, (newVal) => {
  if (!newVal) form.reset();
});
</script>

<template>
  <div 
    v-if="show" 
    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center"
    aria-modal="true"
  >
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
      <h2 class="text-xl font-bold mb-4">Create New Player</h2>

      <form @submit.prevent="submitForm">
        <label class="block mb-2">Player Name:</label>
        <input 
          v-model="form.player_name" 
          class="border rounded w-full p-2" 
          type="text" 
          required
        />
        <p v-if="form.errors.player_name" class="text-red-500 text-sm mt-2">
          {{ form.errors.player_name }}
        </p>

        <div class="flex justify-end mt-4 gap-2">
          <button type="button" @click="emit('close')" class="bg-gray-300 px-4 py-2 rounded">
            Cancel
          </button>
          <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
            Add Player
          </button>
        </div>
      </form>
    </div>
  </div>
</template>
