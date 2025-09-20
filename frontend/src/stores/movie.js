import { defineStore } from 'pinia';
import { useApi } from '@/composables/useApi';
import { useToast } from '@/composables/useToast';

export const useMovieStore = defineStore('movies', {
  state: () => ({
    movies: [],
    isLoading: false,
  }),

  actions: {
    async fetchMovies(searchTerm = 'batman') {
      const { api } = useApi();
      const { notifyError } = useToast();
      
      this.isLoading = true;
      
      try {
        const response = await api.get('movies/search', {
          params: { q: searchTerm } 
        });

        this.movies = response.data;
      } catch (error) {
        notifyError('Erro ao buscar filmes:', error.response?.data?.message || error.message);
        this.movies = [];
      } finally {
        this.isLoading = false;
      }
    },
  },
});