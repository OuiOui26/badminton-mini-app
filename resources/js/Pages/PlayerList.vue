<script setup lang="ts">
import { defineProps, ref } from 'vue';
import type { Player } from '../types/player';
import PlayerModal from '../components/CreatePlayerModal.vue';
import BackButton from '../components/BackButton.vue';
const props = defineProps<{
  players : Player[],
}>();

const showCreatePlayerModal = ref(false); 

const openCreateModal = () => {
  showCreatePlayerModal.value = true;
};

const closeCreateModal = () => {
  showCreatePlayerModal.value = false;
};

</script>

<template>
  <div class="w-1/2 flex flex-col mx-auto mt-12 jusity-center items-center mt-4 bg-white p-4 shadow-md rounded-lg">
    <div class="flex w-full justify-between">

      <BackButton />
      
      <button @click="openCreateModal" class="border border-1 bg-white text-green-600 font-bold py-2 px-4 rounded-lg hover:bg-green-200">
        ➕ Create New Player
      </button>

    </div>
    <h2 class="text-lg font-semibold mb-2">All Players </h2>

    <div class=" mt-10">
      <div v-if="props.players.length" class=" pl-5 grid grid-cols-4 gap-4">
      <div v-for="player in props.players" :key="player.id" class="mb-1 p-4 bg-green-200 rounded-lg">
        <p>{{ player.player_name }}</p>
      </div>
    </div>
    <p v-else class="text-gray-500">No players added yet.</p>
    </div>

  </div>
  <PlayerModal :show="showCreatePlayerModal" @close="closeCreateModal" />
</template>
