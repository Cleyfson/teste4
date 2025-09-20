<template>
  <div class="bg-gray-50 min-h-screen p-6">
    <div class="max-w-4xl mx-auto">
      <div class="flex justify-between items-center px-1 py-2">
        <h1 class="text-xl font-medium text-gray-800 mb-4">Meus favoritos</h1>
        <button 
          @click="goToMovies"
          class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-md text-sm text-gray-700 flex justify-between items-center"
        >
          <h1>Voltar para Filmes</h1>
          <ArrowRight class="pl-2"/>
        </button>
      </div>

      <FavoriteCard>
        <template #header>
          <FavoriteSearchBar />
        </template>

        <FavoriteTable />
      </FavoriteCard>
    </div>
  </div>
</template>

<script setup>
  import { onMounted } from 'vue';
  import FavoriteCard from '@/components/favorite/FavoriteCard.vue'
  import FavoriteSearchBar from '@/components/favorite/FavoriteSearchBar.vue'
  import FavoriteTable from '@/components/favorite/FavoriteTable.vue'
  import { ArrowRight } from 'lucide-vue-next'
  import { useRouter } from 'vue-router'
  import { useMovieStore } from '@/stores/movie';

  const router = useRouter()
  const movieStore = useMovieStore();

  onMounted(() => {
    if (!movieStore.genres.length) {
      movieStore.fetchGenres();
    }
  });

  const goToMovies = () => {
    router.push('/movies')
  }
</script>
