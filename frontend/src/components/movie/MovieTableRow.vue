<template>
  <tr class="hover:bg-gray-50 group">
    <td @click="$emit('show-details', movie.id)" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 cursor-pointer">
      <div class="flex items-center space-x-2">
        <img 
          v-if="movie.poster_path" 
          :src="posterUrl" 
          :alt="movie.title" 
          class="h-12 w-12 rounded object-cover"
          @error="handleImageError"
        />
        <LucideFilm v-else class="h-8 w-8 text-gray-400" />
        <span>{{ movie.title }}</span>
      </div>
    </td>

    <td @click="$emit('show-details', movie.id)" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 cursor-pointer">
      {{ language }}
    </td>

    <td @click="$emit('show-details', movie.id)" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 cursor-pointer">
      {{ releaseYear }}
    </td>

    <td class="pl-6 py-4 whitespace-nowrap text-sm text-gray-500">
      <div class="flex items-center opacity-0 group-hover:opacity-100 transition-opacity gap-4">
        <button 
          class="flex items-center gap-1 px-3 py-1 mr-5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded"
          @click.stop="favoriteStore.addFavorite(movie.id)"
        >
          <Plus class="h-4 w-4" />
          Add to Favorites
        </button>
      </div>
    </td>
  </tr>
</template>

<script setup>
import { computed } from 'vue';
import { LucideFilm, Plus } from 'lucide-vue-next';
import { useFavoriteStore } from '@/stores/favorite';

const favoriteStore = useFavoriteStore();

const props = defineProps({
  movie: {
    type: Object,
    required: true
  }
});

const emit = defineEmits(['show-details']);

const posterUrl = computed(() => `https://image.tmdb.org/t/p/w92${props.movie.poster_path}`);
const language = computed(() => props.movie.original_language?.toUpperCase() || '');
const releaseYear = computed(() => {
  if (!props.movie.release_date) return 'N/A';
  return new Date(props.movie.release_date).getFullYear();
});

const handleImageError = (e) => {
  e.target.style.display = 'none';
};
</script>