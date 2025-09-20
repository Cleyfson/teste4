<?php

namespace Tests\Unit\Application\UseCases\Favorite;

use App\Application\UseCases\Favorite\FavoriteAddUseCase;
use App\Domain\Entities\Favorite;
use Tests\Mocks\FavoriteRepositoryMock;
use Tests\Mocks\MovieProviderMock;
use Tests\TestCase;

class FavoriteAddUseCaseTest extends TestCase
{
    private FavoriteRepositoryMock $favoriteRepositoryMock;
    private MovieProviderMock $movieProviderMock;
    private FavoriteAddUseCase $favoriteAddUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->favoriteRepositoryMock = new FavoriteRepositoryMock();
        $this->movieProviderMock = new MovieProviderMock();
        $this->favoriteAddUseCase = new FavoriteAddUseCase(
            $this->favoriteRepositoryMock,
            $this->movieProviderMock
        );
    }

    public function test_add_new_favorite_successfully(): void
    {
        $userId = 1;
        $movieId = 123;

        $this->movieProviderMock->setMovieDetails($movieId, [
            'title' => 'Inception',
            'original_title' => 'Inception',
            'overview' => 'A mind-bending thriller.',
            'poster_path' => '/poster.jpg',
            'release_date' => '2010-07-16',
            'genres' => [
                ['id' => 1, 'name' => 'Action'],
                ['id' => 2, 'name' => 'Sci-Fi'],
            ]
        ]);

        $this->favoriteAddUseCase->execute($userId, $movieId);

        $savedFavorites = $this->favoriteRepositoryMock->getFavorites();
        $this->assertCount(1, $savedFavorites);

        $favorite = $savedFavorites[0];
        $this->assertEquals($userId, $favorite->getUserId());
        $this->assertEquals($movieId, $favorite->getMovieId());
        $this->assertEquals('Inception', $favorite->getMovieTitle());
        $this->assertEquals([1, 2], $favorite->getGenreIds());
    }

    public function test_add_existing_favorite_throws_exception(): void
    {
        $userId = 1;
        $movieId = 123;

        $this->movieProviderMock->setMovieDetails($movieId, [
            'title' => 'Inception',
            'genres' => [['id' => 1], ['id' => 2]]
        ]);

        $this->favoriteAddUseCase->execute($userId, $movieId);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Filme já está nos favoritos.');

        $this->favoriteAddUseCase->execute($userId, $movieId);
    }

    protected function tearDown(): void
    {
        $this->favoriteRepositoryMock->clear();
        parent::tearDown();
    }
}
