import { mount } from '@vue/test-utils';
import { useMovieStore } from '@/stores/movie';
import { createPinia } from 'pinia';
import MovieSearchBar from '@/components/movie/MovieSearchBar.vue';
import { vi } from 'vitest';
import { SearchIcon } from 'lucide-vue-next';

vi.mock('@/stores/movie', () => ({
  useMovieStore: vi.fn(),
}));

vi.mock('@/utils/debounce', () => ({
  default: vi.fn((fn) => fn),
}));

describe('MovieSearchBar.vue', () => {
  let wrapper;
  let movieStore;

  beforeEach(() => {
    movieStore = {
      fetchMovies: vi.fn(),
    };

    useMovieStore.mockReturnValue(movieStore);

    const pinia = createPinia();
    wrapper = mount(MovieSearchBar, {
      global: {
        plugins: [pinia],
        stubs: {
          SearchIcon: true,
        },
      },
    });

    vi.clearAllMocks();
    vi.useFakeTimers();
  });

  afterEach(() => {
    vi.useRealTimers();
  });

  it('renderiza corretamente com o campo de busca e ícone', () => {
    const input = wrapper.find('input');
    expect(input.exists()).toBe(true);
    expect(input.attributes('placeholder')).toBe('Buscar filme');
    
    const icon = wrapper.findComponent(SearchIcon);
    expect(icon.exists()).toBe(true);
  });

  it('inicializa com searchTerm vazio', () => {
    expect(wrapper.vm.searchTerm).toBe('');
  });

  it('atualiza searchTerm quando o input é alterado', async () => {
    const input = wrapper.find('input');
    await input.setValue('Ação');
    
    expect(wrapper.vm.searchTerm).toBe('Ação');
  });

  it('usa debounce ao digitar no input', async () => {
    const input = wrapper.find('input');
    await input.setValue('Ação');
    
    vi.advanceTimersByTime(500);
    
    expect(movieStore.fetchMovies).toHaveBeenCalledTimes(1);
    expect(movieStore.fetchMovies).toHaveBeenLastCalledWith('Ação');
  });

  it('chama fetchMovies imediatamente ao pressionar Enter', async () => {
    const input = wrapper.find('input');
    await input.setValue('Comédia');
    await input.trigger('keyup.enter');
    
    expect(movieStore.fetchMovies).toHaveBeenCalledTimes(1);
    expect(movieStore.fetchMovies).toHaveBeenLastCalledWith('Comédia');
    
    vi.advanceTimersByTime(500);
    expect(movieStore.fetchMovies).toHaveBeenCalledTimes(1);
  });

  it('limpa o debounce ao pressionar Enter', async () => {
    const input = wrapper.find('input');
    await input.setValue('Drama');
    await input.trigger('keyup.enter');
    
    vi.advanceTimersByTime(500);
    expect(movieStore.fetchMovies).toHaveBeenCalledTimes(1);
  });
});