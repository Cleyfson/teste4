import { mount } from '@vue/test-utils';
import { useFavoriteStore } from '@/stores/favorite';
import { useMovieStore } from '@/stores/movie';
import { createPinia } from 'pinia';
import FavoriteSearchBar from '@/components/favorite/FavoriteSearchBar.vue';
import { vi } from 'vitest';

vi.mock('@/stores/movie', () => ({
  useMovieStore: vi.fn(),
}));

vi.mock('@/stores/favorite', () => ({
  useFavoriteStore: vi.fn(),
}));

const mockGenres = [
  { id: 1, name: 'Ação' },
  { id: 2, name: 'Comédia' },
  { id: 3, name: 'Drama' },
];

describe('FavoriteSearchBar.vue', () => {
  let wrapper;
  let movieStore;
  let favoriteStore;

  beforeEach(() => {
    movieStore = {
      genres: mockGenres,
    };

    favoriteStore = {
      fetchFavorites: vi.fn(),
    };

    useMovieStore.mockReturnValue(movieStore);
    useFavoriteStore.mockReturnValue(favoriteStore);

    const pinia = createPinia();
    wrapper = mount(FavoriteSearchBar, {
      global: {
        plugins: [pinia],
      },
    });
  });

  it('renderiza corretamente com os gêneros', () => {
    const select = wrapper.find('select');
    expect(select.exists()).toBe(true);
    
    const options = wrapper.findAll('option');
    expect(options.length).toBe(mockGenres.length + 1);
    
    expect(options[0].text()).toBe('Todos');
    expect(options[0].attributes('value')).toBe('');
    
    mockGenres.forEach((genre, index) => {
      expect(options[index + 1].text()).toBe(genre.name);
      expect(options[index + 1].attributes('value')).toBe(genre.id.toString());
    });
  });

  it('chama fetchFavorites no mounted sem filtro', () => {
    expect(favoriteStore.fetchFavorites).toHaveBeenCalledTimes(1);
    expect(favoriteStore.fetchFavorites).toHaveBeenCalledWith();
  });

  it('atualiza o selectedGenreId quando um gênero é selecionado', async () => {
    const select = wrapper.find('select');
    await select.setValue('2');
    
    expect(wrapper.vm.selectedGenreId).toBe(2);
  });

  it('chama fetchFavorites com o parâmetro de gênero quando um gênero é selecionado', async () => {
    const select = wrapper.find('select');
    await select.setValue('1');

    expect(favoriteStore.fetchFavorites).toHaveBeenCalledTimes(2);
    expect(favoriteStore.fetchFavorites).toHaveBeenLastCalledWith({ genre_id: 1 });
  });

  it('chama fetchFavorites sem parâmetro quando "Todos" é selecionado', async () => {

    const select = wrapper.find('select');
    await select.setValue('3');
    
    await select.setValue('');
    
    expect(favoriteStore.fetchFavorites).toHaveBeenCalledTimes(3);
  });

  it('exibe a label corretamente', () => {
    const label = wrapper.find('label');
    expect(label.text()).toBe('Escolha o gênero:');
    expect(label.attributes('for')).toBe('genre-select');
  });
});