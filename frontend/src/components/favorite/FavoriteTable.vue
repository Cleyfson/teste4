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
                  <Clapperboard class="h-40 w-40"/>
                </div>
                <p class="text-gray-500 mb-4">Você ainda não possui favoritos com esse genero</p>
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
  import { Clapperboard } from 'lucide-vue-next';
  import { useFavoriteStore } from '@/stores/favorite';
  import { useMovieStore } from '@/stores/movie';
  import FavoriteTableHeader from './FavoriteTableHeader.vue';
  import FavoriteTableRow from './FavoriteTableRow.vue';
  import MovieDetailsModal from '../movie/MovieDetailsModal.vue';

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
