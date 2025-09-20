<template>
  <div class="fixed inset-0 z-10 bg-gray-500/40 overflow-y-auto">
    <div class="absolute top-1/2 left-0 right-0 mx-auto max-w-2xl bg-white rounded-lg shadow-sm transform -translate-y-1/2">
      <div class="flex justify-between items-center px-6 pt-6">
        <div class="flex items-center gap-3">
          <img :src="imageUrl(movie.poster_path)" alt="Poster do Filme" class="rounded shadow" />
          <h2 class="text-lg font-semibold text-gray-800">{{ movie.title }}</h2>
        </div>
        <button @click="$emit('close')" class="text-gray-400 hover:text-gray-500" id="close-button">
          <XIcon class="h-5 w-5" />
        </button>
      </div>

      <div class="relative flex py-4 items-center">
        <div class="flex-grow border-t border-gray-400/30"></div>
        <div class="flex-grow border-t border-gray-400/30"></div>
      </div>

      <div class="space-y-4 px-6 pb-6 text-sm text-gray-800">
        <div>
          <span class="font-medium text-gray-500">Título Original:</span> {{ movie.original_title }}
        </div>

        <div>
          <span class="font-medium text-gray-500">Lançamento:</span> {{ formatDate(movie.release_date) }}
        </div>

        <div>
          <span class="font-medium text-gray-500">Duração:</span> {{ formatRuntime(movie.runtime) }}
        </div>

        <div>
          <span class="font-medium text-gray-500">Língua Original:</span> {{ movie.original_language.toUpperCase() }}
        </div>

        <div v-if="movie.genres.length">
          <span class="font-medium text-gray-500">Gêneros:</span>
          <span>{{ movie.genres.map(g => g.name).join(', ') }}</span>
        </div>

        <div>
          <span class="font-medium text-gray-500">País de Origem:</span>
          <span>{{ movie.production_countries.map(c => c.name).join(', ') }}</span>
        </div>

        <div v-if="movie.production_companies.length">
          <span class="font-medium text-gray-500">Produção:</span>
          <span>{{ movie.production_companies.map(c => c.name).join(', ') }}</span>
        </div>

        <div>
          <span class="font-medium text-gray-500">Popularidade:</span> {{ movie.popularity.toFixed(1) }}
        </div>

        <div class="flex items-center gap-1">
          <span class="font-medium text-gray-500">Nota:</span>
          <span class="text-yellow-500">★</span>
          <span>{{ movie.vote_average }} ({{ movie.vote_count }} votos)</span>
        </div>

        <div v-if="movie.imdb_id">
          <span class="font-medium text-gray-500">IMDb:</span>
          <a :href="`https://www.imdb.com/title/${movie.imdb_id}`" target="_blank" class="text-blue-600 hover:underline">
            Ver no IMDb
          </a>
        </div>

        <div>
          <span class="font-medium text-gray-500">Sinopse:</span>
          <p class="mt-1 text-justify">{{ movie.overview }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
  import { XIcon } from 'lucide-vue-next';

  defineProps({
    movie: {
      type: Object,
      required: true,
    },
  });

  defineEmits(['close']);

  const imageUrl = (path) => `https://image.tmdb.org/t/p/w200${path}`;
  const formatDate = (dateStr) =>
    new Date(dateStr).toLocaleDateString('pt-BR', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
    });

  const formatRuntime = (minutes) => {
    if (!minutes) return '-';
    const h = Math.floor(minutes / 60);
    const m = minutes % 60;
    return `${h}h ${m}min`;
  };
</script>
