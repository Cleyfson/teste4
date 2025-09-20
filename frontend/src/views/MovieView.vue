<template>
  <div class="bg-gray-50 min-h-screen p-6">
    <div class="max-w-4xl mx-auto">
      <div class="flex justify-between items-center px-1 py-2">
        <h1 class="text-xl font-medium text-gray-800 mb-4">Buscador de filmes</h1>
        <button 
          @click="goToFavorites"
          class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-md text-sm text-gray-700 flex justify-between items-center"
        >
          <h1>Favoritos</h1>
          <ArrowRight class="pl-2"/>
        </button>
      </div>

      <MovieCard>
        <template #header>
          <MovieSearchBar />
        </template>

        <MovieTable />
      </MovieCard>
    </div>
  </div>
</template>

<script setup>
  import MovieCard from '@/components/movie/MovieCard.vue'
  import MovieSearchBar from '@/components/movie/MovieSearchBar.vue'
  import MovieTable from '@/components/movie/MovieTable.vue'
  import { ArrowRight } from 'lucide-vue-next';
  import { useRouter } from 'vue-router'

  const router = useRouter()

  const goToFavorites = () => {
    router.push('/favorites')
  }
</script>
  