<template>
  <div class="flex items-center justify-between w-full">
    <div class="relative">
      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <SearchIcon class="h-4 w-4 text-gray-400" />
      </div>
      <input
        v-model="searchTerm"
        type="text"
        placeholder="Buscar filme"
        class="pl-10 pr-4 py-2 border border-gray-200 rounded-md bg-gray-100 w-72 text-sm focus:ring-2 focus:ring-indigo-500"
        @keyup.enter="handleSearch"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';
import { useMovieStore } from '@/stores/movie';
import { SearchIcon } from 'lucide-vue-next';

const searchTerm = ref('');
const movieStore = useMovieStore();
let debounceTimeout = null;

const debounce = (fn, delay) => {
  return (...args) => {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
      fn(...args);
    }, delay);
  };
};

const fetchMovies = () => {
  movieStore.fetchMovies(searchTerm.value);
};

const debouncedFetch = debounce(fetchMovies, 500);

watch(searchTerm, debouncedFetch);

onMounted(() => {
  movieStore.fetchMovies();
});

const handleSearch = () => {
  clearTimeout(debounceTimeout);
  fetchMovies();
};
</script>