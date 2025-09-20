<template>
  <div class="flex items-center justify-end w-full">
    <div class="relative">
      <label for="genre-select" class="block mb-2 text-sm font-medium text-gray-900">Escolha o gênero:</label>
      <select
        id="genre-select"
        v-model="selectedGenreId"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
        @change="handleGenreChange"
      >
        <option value="">Selecione um gênero</option>
        <option v-for="genre in movieStore.genres" :key="genre.id" :value="genre.id">
          {{ genre.name }}
        </option>
      </select>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { useMovieStore } from '@/stores/movie';
import { useFavoriteStore } from '@/stores/favorite';

const selectedGenreId = ref('');
const movieStore = useMovieStore();
const favoriteStore = useFavoriteStore();

let debounceTimeout = null;

const debounce = (fn, delay) => {
  return (...args) => {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
      fn(...args);
    }, delay);
  };
};

const fetchFavorites = () => {
  const params = {
    genre_id: selectedGenreId.value,
  };

  favoriteStore.fetchFavorites(params);
};

const debouncedFetch = debounce(fetchFavorites, 500);

watch(selectedGenreId, debouncedFetch);

onMounted(() => {
  favoriteStore.fetchFavorites();
});

const handleGenreChange = () => {
  fetchFavorites();
};
</script>
