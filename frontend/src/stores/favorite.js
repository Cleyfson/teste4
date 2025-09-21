import { defineStore } from 'pinia';
import { useApi } from '@/composables/useApi';
import { useToast } from '@/composables/useToast';
import { useLoading } from '@/composables/useLoading';

export const useFavoriteStore = defineStore('favorites', {
  state: () => ({
    favorites: [],
  }),

  actions: {
    async fetchFavorites(params = {}) {
      const { api } = useApi();
      const { notifyError } = useToast();
      const loading = useLoading();

      loading.start();

      try {
        const response = await api.get('favorites', { params });
        this.favorites = response.data;
      } catch (error) {
        notifyError('Erro ao buscar favoritos:', error.response?.data?.message || error.message);
        this.favorites = [];
      } finally {
        loading.stop();
      }
    },

    async addFavorite(movieId) {
      const { api } = useApi();
      const { notifyError, notifySuccess } = useToast();
      const loading = useLoading();

      loading.start();

      try {
        const response = await api.post('favorites', { movie_id: movieId });
        notifySuccess('Filme adicionado aos favoritos!');
        await this.fetchFavorites();
        return response.data;
      } catch (error) {
        notifyError('Erro ao adicionar favorito:', error.response?.data?.message || error.message);
      } finally {
        loading.stop();
      }
    },

    async removeFavorite(movieId) {
      const { api } = useApi();
      const { notifyError, notifySuccess } = useToast();
      const loading = useLoading();

      loading.start();
      try {
        const response = await api.delete('favorites', { data: { movie_id: movieId } });
        notifySuccess('Filme removido dos favoritos!');
        await this.fetchFavorites();
        return response.data;
      } catch (error) {
        notifyError('Erro ao remover favorito:', error.response?.data?.message || error.message);
      } finally {
        loading.stop();
      }
    },
  },
});
