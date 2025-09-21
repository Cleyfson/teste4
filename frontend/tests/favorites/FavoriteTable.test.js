import { shallowMount, mount } from '@vue/test-utils';
import { useFavoriteStore } from '@/stores/favorite';
import { useMovieStore } from '@/stores/movie';
import { createPinia } from 'pinia';
import FavoriteTable from '@/components/favorite/FavoriteTable.vue';
import FavoriteTableRow from '@/components/favorite/FavoriteTableRow.vue';
import FavoriteTableHeader from '@/components/favorite/FavoriteTableHeader.vue';
import MovieDetailsModal from '@/components/movie/MovieDetailsModal.vue';

import { vi } from 'vitest';

vi.mock('@/stores/favorite', () => ({
  useFavoriteStore: vi.fn(),
}));

vi.mock('@/stores/movie', () => ({
  useMovieStore: vi.fn(),
}));

const mockMovie = {
  id: 1,
  title: 'The Matrix',
  year: 1999,
  director: 'Lana Wachowski',
};

describe('FavoriteTable.vue', () => {
  let wrapper;
  let favoriteStore;
  let movieStore;

  beforeEach(() => {
    favoriteStore = {
      favorites: [mockMovie],
    };

    movieStore = {
      fetchMovie: vi.fn().mockResolvedValue(mockMovie),
    };

    useFavoriteStore.mockReturnValue(favoriteStore);
    useMovieStore.mockReturnValue(movieStore);

    wrapper = shallowMount(FavoriteTable);
  });

  it('renderiza os filmes favoritos corretamente', () => {
    const rows = wrapper.findAllComponents(FavoriteTableRow);
    expect(rows.length).toBe(1);
    expect(rows.at(0).props().movie).toEqual(mockMovie);
  });

  it('renderiza os componentes filhos corretamente', () => {
    const pinia = createPinia();
    wrapper = mount(FavoriteTable, {
      global: {
        plugins: [pinia],
      },
    });

    expect(wrapper.findComponent(FavoriteTableRow).exists()).toBe(true);
    expect(wrapper.findComponent(FavoriteTableHeader).exists()).toBe(true);
  });

  it('exibe mensagem quando não há favoritos', () => {
    favoriteStore.favorites = [];
    wrapper = shallowMount(FavoriteTable);
    
    expect(wrapper.find('td[colspan="5"]').exists()).toBe(true);
    expect(wrapper.text()).toContain('Você ainda não possui favoritos com esse genero');
  });

  it('abre modal de detalhes quando showMovieDetails é chamado', async () => {
    await wrapper.vm.showMovieDetails(1);
    
    expect(movieStore.fetchMovie).toHaveBeenCalledWith(1);
    expect(wrapper.vm.isMovieModalOpen).toBe(true);
    expect(wrapper.vm.selectedMovie).toEqual(mockMovie);
  });

  it('fecha modal de detalhes corretamente', async () => {
    wrapper.vm.closeMovieModal();
    
    expect(wrapper.vm.isMovieModalOpen).toBe(false);
    expect(wrapper.vm.selectedMovie).toBeNull();
  });

  it('abre modal de detalhes apenas com filme válido', async () => {
    await wrapper.vm.showMovieDetails(1);
    expect(movieStore.fetchMovie).toHaveBeenCalledWith(1);
    
    await wrapper.vm.$nextTick();
    
    expect(wrapper.vm.isMovieModalOpen).toBe(true);
    expect(wrapper.vm.selectedMovie).toEqual(mockMovie);
    
    const modal = wrapper.findComponent(MovieDetailsModal);
    expect(modal.exists()).toBe(true);
    expect(modal.props('movie')).toEqual(mockMovie);
  });

  
  it('fecha modal corretamente', async () => {
    wrapper.vm.isMovieModalOpen = true;
    wrapper.vm.selectedMovie = mockMovie;
    await wrapper.vm.$nextTick();
    
    wrapper.vm.closeMovieModal();
    await wrapper.vm.$nextTick();
    
    expect(wrapper.vm.isMovieModalOpen).toBe(false);
    expect(wrapper.vm.selectedMovie).toBeNull();
    
    expect(wrapper.findComponent(MovieDetailsModal).exists()).toBe(false);
  });
});