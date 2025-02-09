<script setup>
import { defineProps } from "vue";

const props = defineProps({
  players: Array,
});
</script>

<template>
  <div class="mt-4 bg-white p-4 shadow-md rounded-lg">
    <h2 class="text-lg font-semibold mb-2">Players in This Payment</h2>

    <ul v-if="players.length" class="list-disc pl-5">
      <li v-for="player in players" :key="player.id" class="mb-1">
        {{ player.player_name }}
      </li>
    </ul>

    <p v-else class="text-gray-500">No players added yet.</p>
  </div>
</template>
