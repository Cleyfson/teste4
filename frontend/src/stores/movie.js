import { defineStore } from 'pinia';
import { useApi } from '@/composables/useApi';
import { useToast } from '@/composables/useToast';

export const useMovieStore = defineStore('movies', {
  state: () => ({
    movies: [],
  }),

  actions: {
    async fetchMovies(searchTerm = 'batman') {
      const { api } = useApi();
      const { notifyError } = useToast();
            
      try {
        const response = await api.get('movies/search', {
          params: { q: searchTerm } 
        });

        this.movies = response.data;
      } catch (error) {
        notifyError('Erro ao buscar filmes:', error.response?.data?.message || error.message);
        this.movies = [];
      }
    },

    async fetchMovie(id) {
      const { api } = useApi();
      const { notifyError } = useToast();

      try {
        const response = await api.get(`movies/${id}`);

        return response.data;
      } catch (error) {
        notifyError('Erro ao buscar filme:' + (error.response?.data?.message || error));
      }
    },
  },
});