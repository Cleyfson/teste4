import { mount } from '@vue/test-utils';
import { vi } from 'vitest';
import FavoriteTableRow from '@/components/favorite/FavoriteTableRow.vue';
import { useFavoriteStore } from '@/stores/favorite';

const mockRemoveFavorite = vi.fn();

vi.mock('@/stores/movie', () => ({
  useMovieStore: () => ({
    genreMap: { 28: 'Ação', 12: 'Aventura' },
  }),
}));

vi.mock('@/stores/favorite', () => ({
  useFavoriteStore: () => ({
    removeFavorite: mockRemoveFavorite,
  }),
}));

describe('FavoriteTableRow', () => {
  const movie = {
    movie_id: 1,
    movie_title: 'Filme de Teste',
    original_title: 'Original Test Movie',
    release_date: '2025-04-20',
    genre_ids: [28, 12],
    poster_path: '/path/to/poster.jpg',
  };

  it('renderiza corretamente as informações do filme', () => {
    const wrapper = mount(FavoriteTableRow, {
      props: { movie },
    });

    expect(wrapper.text()).toContain('Filme de Teste');
    expect(wrapper.text()).toContain('Original Test Movie');
    expect(wrapper.text()).toContain('20 de abril de 2025');
    expect(wrapper.text()).toContain('Ação');
    expect(wrapper.text()).toContain('Aventura');

    const posterImage = wrapper.find('img');
    expect(posterImage.attributes('src')).toBe('https://image.tmdb.org/t/p/w92/path/to/poster.jpg');
  });

  it('dispara o evento show-details ao clicar no botão de detalhes', async () => {
    const wrapper = mount(FavoriteTableRow, {
      props: { movie },
    });

    const button = wrapper.find('[title="Ver detalhes"]');
    await button.trigger('click');

    expect(wrapper.emitted()['show-details']).toBeTruthy();
    expect(wrapper.emitted()['show-details'][0]).toEqual([movie.movie_id]);
  });

  it('remove o filme dos favoritos ao clicar no botão de remover', async () => {
    const wrapper = mount(FavoriteTableRow, {
      props: { movie },
    });

    const removeButton = wrapper.find('[title="Remover"]');
    await removeButton.trigger('click');

    expect(useFavoriteStore().removeFavorite).toHaveBeenCalled();
  });
});