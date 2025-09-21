import { defineStore } from 'pinia';
import { useApi } from '@/composables/useApi';
import { useToast } from '@/composables/useToast';
import { useLoading } from '@/composables/useLoading';

export const useMovieStore = defineStore('movies', {
  state: () => ({
    movies: [],
    genres: [],
  }),

  getters: {
    genreMap(state) {
      return state.genres.reduce((map, genre) => {
        map[genre.id] = genre.name;
        return map;
      }, {});
    },
  },

  actions: {
    async fetchMovies(searchTerm = 'batman') {
      const { api } = useApi();
      const { notifyError } = useToast();
      const loading = useLoading();

      loading.start();

      try {
        const response = await api.get('movies/search', {
          params: { q: searchTerm } 
        });

        this.movies = response.data;
      } catch (error) {
        notifyError('Erro ao buscar filmes:' + error.response?.data?.message || error.message);
        this.movies = [];
      } finally {
        loading.stop();
      }
    },

    async fetchMovie(id) {
      const { api } = useApi();
      const { notifyError } = useToast();
      const loading = useLoading();

      loading.start();

      try {
        const response = await api.get(`movies/${id}`);

        return response.data;
      } catch (error) {
        notifyError('Erro ao buscar filme:' + (error.response?.data?.message || error.message));
      } finally {
        loading.stop();
      }
    },

    async fetchGenres() {
      const { api } = useApi();
      const { notifyError } = useToast();
      const loading = useLoading();

      loading.start();
      
      try {
        const response = await api.get('/movies/genres');

        this.genres = response.data;
      } catch (error) {
        notifyError('Erro ao buscar gêneros:', (error.response?.data?.message || error.message));
      } finally {
        loading.stop();
      }
    },
  },
});