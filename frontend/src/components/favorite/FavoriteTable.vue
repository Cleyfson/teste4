<template>
  <div>
    <table class="min-w-full divide-y divide-gray-200">
      <FavoriteTableHeader />
      <tbody class="bg-white">
        <template v-if="favoriteStore.favorites.length > 0">
          <FavoriteTableRow 
            v-for="movie in favoriteStore.favorites" 
            :key="movie.id" 
            :movie="movie"
            @show-details="showMovieDetails"
          />
        </template>
        <template v-else>
          <tr>
            <td colspan="5" class="px-6 py-50 text-center">
              <div class="flex flex-col items-center justify-center">
                <div class="bg-gray-100 rounded-full p-6 mb-4">
                  <img :src="BookOpen" alt="open book" />
                </div>
                <p class="text-gray-500 mb-4">Você ainda não possui favoritos</p>
                <button 
                  class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium flex items-center"
                >
                  <LucidePlus class="h-4 w-4 mr-1" />
                  Adicione um filme como favorito
                </button>
              </div>
            </td>
          </tr>
        </template>
      </tbody>
    </table>

    <MovieDetailsModal 
      v-if="isMovieModalOpen" 
      :movie="selectedMovie"
      @close="closeMovieModal"
    />
  </div>
</template>

<script setup>
  import { ref } from 'vue';
  import { useFavoriteStore } from '@/stores/favorite';
  import { useMovieStore } from '@/stores/movie';
  import { LucidePlus } from 'lucide-vue-next';
  import FavoriteTableHeader from './FavoriteTableHeader.vue';
  import FavoriteTableRow from './FavoriteTableRow.vue';
  import MovieDetailsModal from '../movie/MovieDetailsModal.vue';
  import BookOpen from '@/assets/svg/book_open1.svg';

  const favoriteStore = useFavoriteStore();
  const movieStore = useMovieStore();

  const isMovieModalOpen = ref(false);
  const selectedMovie = ref(null);

  const showMovieDetails = async (id) => {
    const movie = await movieStore.fetchMovie(id);
    selectedMovie.value = movie;
    isMovieModalOpen.value = true;
  };

  const closeMovieModal = () => {
    isMovieModalOpen.value = false;
    selectedMovie.value = null;
  };
</script>
