<script setup>
import { ref, onMounted, defineEmits, computed } from "vue";

const emit = defineEmits(["close", "add-player"]);
const players = ref([]);
const selectedPlayers = ref([]);
const selectAll = ref(false);
const searchQuery = ref("");

const props = defineProps({
  selectedPlayers: Array
});

const fetchPlayers = async () => {
  try {
    const response = await fetch("/players"); 
    players.value = await response.json();
  } catch (error) {
    console.error("Error fetching players:", error);
  }
};

onMounted(() => {
  selectedPlayers.value = [...props.selectedPlayers];
  fetchPlayers();
});

const toggleSelectAll = () => {
  if (selectAll.value) {
    selectedPlayers.value = players.value.map(player => player);
  } else {
    selectedPlayers.value = [];
  }
};

const isAllSelected = computed(() => selectedPlayers.value.length === players.value.length);

const addPlayers = () => {
  emit("add-player", selectedPlayers.value);
  emit("close");
};

const filteredPlayers = computed(() => {
  if (!searchQuery.value) return players.value;
  return players.value.filter(player =>
    player.player_name.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

</script>

<template>
  <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
      <h2 class="text-xl font-bold mb-4">Select Players</h2>
      
      <input 
        v-model="searchQuery" 
        type="text" 
        placeholder="Search players..." 
        class="w-full p-2 border rounded-lg mb-2"
      />

      <div v-if="filteredPlayers.length" class="flex items-center space-x-2 p-2 border-b border-gray-300">
        <input type="checkbox" v-model="selectAll" @change="toggleSelectAll" />
        <span class="font-semibold">Select All</span>
      </div>


      <div class="max-h-60 overflow-y-auto">
        <label 
          v-for="player in filteredPlayers" 
          :key="player.id" 
          class="flex items-center space-x-2 p-2 hover:bg-gray-100 cursor-pointer"
        >
          <input 
            type="checkbox" 
            v-model="selectedPlayers" 
            :value="player" 
          />
          <span>{{ player.player_name }}</span>
        </label>
      </div>

      <div class="flex justify-end mt-4 gap-2">
        <button @click="emit('close')" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
        <button @click="addPlayers" class="bg-green-500 text-white px-4 py-2 rounded">Add</button>
      </div>
    </div>
  </div>
</template>
