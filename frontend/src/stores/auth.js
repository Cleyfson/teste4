import { defineStore } from 'pinia';
import { useApi } from '@/composables/useApi';
import { useToast } from '@/composables/useToast';
import { useLoading } from '@/composables/useLoading';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: localStorage.getItem('access_token') || null,
  }),

  getters: {
    isAuthenticated: (state) => !!state.token,
  },

  actions: {
    setToken(token) {
      this.token = token;
      localStorage.setItem('access_token', token);
    },

    clearToken() {
      this.token = null;
      localStorage.removeItem('access_token');
    },

    async login(credentials) {
      const { api } = useApi();
      const { notifyError } = useToast();
      const loading = useLoading();

      loading.start();

      try {
        const response = await api.post('/auth/login', credentials);
        this.setToken(response.data.access_token);

        return response.data;
      } catch (error) {
        notifyError('Erro ao fazer login:' + (error.response?.data?.message || error));
        throw error;
      } finally {
        loading.stop();
      }
    },

    async register(credentials) {
      const { api } = useApi();
      const { notifyError } = useToast();
      const loading = useLoading();

      loading.start();

      try {
        const response = await api.post('/auth/register', credentials);

        return response.data;
      } catch (error) {
        const message = error.response?.data?.error || error.response?.data?.message || 'Erro desconhecido';
        notifyError('Erro ao registrar: ' + message);
        throw message;
      } finally {
        loading.stop();
      }
    },
      
    async logout() {
      const { api } = useApi();
      const { notifyError } = useToast();
      const loading = useLoading();

      loading.start();

      try {
        await api.post('/auth/logout');

        this.clearToken();
      } catch (error) {
        notifyError('Erro ao deslogar:' + (error.response?.data?.message || error.message));
      } finally {
        loading.stop();
      }
    },
  },
});