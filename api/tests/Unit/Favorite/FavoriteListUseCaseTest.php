<?php

namespace Tests\Unit\Application\UseCases\Favorite;

use App\Application\UseCases\Favorite\FavoriteListUseCase;
use App\Domain\Entities\Favorite;
use Tests\Mocks\FavoriteRepositoryMock;
use Tests\TestCase;

class FavoriteListUseCaseTest extends TestCase
{
    private FavoriteRepositoryMock $favoriteRepositoryMock;
    private FavoriteListUseCase $favoriteListUseCase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->favoriteRepositoryMock = new FavoriteRepositoryMock();
        $this->favoriteListUseCase = new FavoriteListUseCase($this->favoriteRepositoryMock);
        
        $this->addSampleFavorites();
    }

    private function addSampleFavorites(): void
    {
        $favorites = [
            (new Favorite())
                ->setId(1)
                ->setUserId(1)
                ->setMovieId(101)
                ->setMovieTitle('Movie A')
                ->setGenreIds([1, 2]),
                
            (new Favorite())
                ->setId(2)
                ->setUserId(1)
                ->setMovieId(102)
                ->setMovieTitle('Movie B')
                ->setGenreIds([2, 3]),
                
            (new Favorite())
                ->setId(3)
                ->setUserId(1)
                ->setMovieId(103)
                ->setMovieTitle('Movie C')
                ->setGenreIds([1, 3]),
                
            (new Favorite())
                ->setId(4)
                ->setUserId(2)
                ->setMovieId(104)
                ->setMovieTitle('Movie D')
                ->setGenreIds([1])
        ];

        foreach ($favorites as $favorite) {
            $this->favoriteRepositoryMock->add($favorite);
        }
    }

    public function test_list_all_favorites_for_user(): void
    {
        $result = $this->favoriteListUseCase->execute(1);
        
        $this->assertCount(3, $result);
        
        $movieTitles = array_map(fn($fav) => $fav->getMovieTitle(), $result);
        $this->assertEqualsCanonicalizing(
            ['Movie A', 'Movie B', 'Movie C'],
            $movieTitles
        );
    }

    public function test_list_favorites_filtered_by_genre(): void
    {
        $result = $this->favoriteListUseCase->execute(1, 1);
        
        $this->assertCount(2, $result);
        
        $movieTitles = array_map(fn($fav) => $fav->getMovieTitle(), $result);
        $this->assertEqualsCanonicalizing(
            ['Movie A', 'Movie C'],
            $movieTitles
        );
    }

    public function test_list_favorites_for_user_with_no_favorites(): void
    {
        $result = $this->favoriteListUseCase->execute(3);
        
        $this->assertCount(0, $result);
        $this->assertSame([], $result);
    }

    public function test_list_favorites_with_genre_filter_that_matches_none(): void
    {
        $result = $this->favoriteListUseCase->execute(1, 99);
        
        $this->assertCount(0, $result);
        $this->assertSame([], $result);
    }

    public function test_list_returns_proper_favorite_structure(): void
    {
        $result = $this->favoriteListUseCase->execute(1);
        
        $firstFavorite = $result[0];
        $this->assertInstanceOf(Favorite::class, $firstFavorite);
        $this->assertEquals(1, $firstFavorite->getUserId());
        $this->assertEquals(101, $firstFavorite->getMovieId());
        $this->assertEquals('Movie A', $firstFavorite->getMovieTitle());
        $this->assertEquals([1, 2], $firstFavorite->getGenreIds());
    }

    protected function tearDown(): void
    {
        $this->favoriteRepositoryMock->clear();
        parent::tearDown();
    }
}