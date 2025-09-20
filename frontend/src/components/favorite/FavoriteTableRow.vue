<template>
  <tr>
    <td class="px-6 py-4 whitespace-nowrap">
      <img 
        :src="`https://image.tmdb.org/t/p/w92${movie.poster_path}`" 
        alt="poster" 
        class="rounded-md"
      />
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
      <div class="text-sm font-medium text-gray-900">{{ movie.movie_title }}</div>
      <div class="text-sm text-gray-500 italic">{{ movie.original_title }}</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
      {{ formatDate(movie.release_date) }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
      <div class="flex flex-wrap gap-1">
        <span 
          v-for="genreId in movie.genre_ids" 
          :key="genreId" 
          class="bg-indigo-100 text-indigo-800 text-xs font-semibold mr-1 px-2.5 py-0.5 rounded"
        >
          {{ getGenreName(genreId) }}
        </span>
      </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-4">
      <button 
        class="text-indigo-600 hover:text-indigo-900"
        @click="$emit('show-details', movie.movie_id)"
      >
        Ver detalhes
      </button>

      <button 
        class="text-red-600 hover:text-red-800"
        @click="favoriteStore.removeFavorite(movie.movie_id)"
      >
        Remover
      </button>
    </td>
  </tr>
</template>

<script setup>
import { useMovieStore } from '@/stores/movie';
import { useFavoriteStore } from '@/stores/favorite';

const movieStore = useMovieStore();
const favoriteStore = useFavoriteStore();

defineProps({
  movie: {
    type: Object,
    required: true,
  },
});

const getGenreName = (id) => movieStore.genreMap[id] || 'Desconhecido';

const formatDate = (dateString) => {
  if (!dateString) return 'Sem data';
  const date = new Date(dateString);
  return date.toLocaleDateString('pt-BR', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  });
};
</script>
