import { shallowMount, mount } from '@vue/test-utils';
import { createPinia } from 'pinia';
import { vi } from 'vitest';
import MovieTable from '@/components/movie/MovieTable.vue';
import MovieTableRow from '@/components/movie/MovieTableRow.vue';
import MovieTableHeader from '@/components/movie/MovieTableHeader.vue';
import MovieDetailsModal from '@/components/movie/MovieDetailsModal.vue';

import { useMovieStore } from '@/stores/movie';

vi.mock('@/stores/movie', () => ({
  useMovieStore: vi.fn(),
}));

const mockMovie = {
  id: 1,
  title: 'Interstellar',
  year: 2014,
  director: 'Christopher Nolan',
};

describe('MovieTable.vue', () => {
  let wrapper;
  let movieStore;

  beforeEach(() => {
    movieStore = {
      movies: [mockMovie],
      fetchMovie: vi.fn().mockResolvedValue(mockMovie),
    };

    useMovieStore.mockReturnValue(movieStore);

    wrapper = shallowMount(MovieTable);
  });

  it('renderiza os filmes corretamente', () => {
    const rows = wrapper.findAllComponents(MovieTableRow);
    expect(rows.length).toBe(1);
    expect(rows[0].props('movie')).toEqual(mockMovie);
  });

  it('renderiza os componentes filhos corretamente', () => {
    const pinia = createPinia();
    wrapper = mount(MovieTable, {
      global: {
        plugins: [pinia],
      },
    });

    expect(wrapper.findComponent(MovieTableRow).exists()).toBe(true);
    expect(wrapper.findComponent(MovieTableHeader).exists()).toBe(true);
  });

  it('exibe mensagem quando não há filmes', () => {
    movieStore.movies = [];
    useMovieStore.mockReturnValue(movieStore);
    wrapper = shallowMount(MovieTable);

    const td = wrapper.find('td[colspan="5"]');
    expect(td.exists()).toBe(true);
    expect(td.text()).toContain('Não há filmes com esse nome');
    expect(wrapper.find('button').text()).toContain('Busque por um novo filme');
  });

  it('abre modal de detalhes quando showMovieDetails é chamado', async () => {
    await wrapper.vm.showMovieDetails(1);

    expect(movieStore.fetchMovie).toHaveBeenCalledWith(1);
    expect(wrapper.vm.isMovieModalOpen).toBe(true);
    expect(wrapper.vm.selectedMovie).toEqual(mockMovie);
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

  it('exibe modal com detalhes do filme corretamente', async () => {
    await wrapper.vm.showMovieDetails(1);
    await wrapper.vm.$nextTick();

    const modal = wrapper.findComponent(MovieDetailsModal);
    expect(modal.exists()).toBe(true);
    expect(modal.props('movie')).toEqual(mockMovie);
  });
});
