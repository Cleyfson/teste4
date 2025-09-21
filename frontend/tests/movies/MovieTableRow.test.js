import { mount } from '@vue/test-utils';
import { vi } from 'vitest';
import MovieTableRow from '@/components/movie/MovieTableRow.vue';
import { useFavoriteStore } from '@/stores/favorite';

const mockAddFavorite = vi.fn();

vi.mock('@/stores/favorite', () => ({
  useFavoriteStore: () => ({
    addFavorite: mockAddFavorite,
  }),
}));

describe('MovieTableRow.vue', () => {
  const movie = {
    id: 42,
    title: 'Interestelar',
    poster_path: '/poster.jpg',
    original_language: 'en',
    release_date: '2014-11-07',
  };

  beforeEach(() => {
    mockAddFavorite.mockReset();
  });

  it('renderiza corretamente os dados do filme', () => {
    const wrapper = mount(MovieTableRow, {
      props: { movie },
    });

    expect(wrapper.text()).toContain('Interestelar');
    expect(wrapper.text()).toContain('EN');
    expect(wrapper.text()).toContain('2014');

    const img = wrapper.find('img');
    expect(img.exists()).toBe(true);
    expect(img.attributes('src')).toBe('https://image.tmdb.org/t/p/w92/poster.jpg');
  });

  it('dispara o evento show-details ao clicar nas colunas principais', async () => {
    const wrapper = mount(MovieTableRow, {
      props: { movie },
    });

    const cols = wrapper.findAll('td.cursor-pointer');
    for (const col of cols) {
      await col.trigger('click');
    }

    expect(wrapper.emitted()['show-details']).toHaveLength(cols.length);
    for (const call of wrapper.emitted()['show-details']) {
      expect(call).toEqual([movie.id]);
    }
  });

  it('chama addFavorite ao clicar no botão "Add to Favorites"', async () => {
    const wrapper = mount(MovieTableRow, {
      props: { movie },
    });

    const button = wrapper.find('button');
    await button.trigger('click');

    expect(mockAddFavorite).toHaveBeenCalledWith(movie.id);
  });

  it('oculta a imagem ao disparar erro de carregamento', async () => {
    const wrapper = mount(MovieTableRow, {
      props: { movie },
    });

    const img = wrapper.find('img');
    await img.trigger('error');

    expect(img.element.style.display).toBe('none');
  });
});
