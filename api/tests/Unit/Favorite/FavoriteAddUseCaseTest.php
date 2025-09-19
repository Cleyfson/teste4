<?php

namespace Tests\Unit\Application\UseCases\Favorite;

use App\Application\UseCases\Favorite\FavoriteAddUseCase;
use App\Domain\Entities\Favorite;
use Tests\Mocks\FavoriteRepositoryMock;
use Tests\TestCase;

class FavoriteAddUseCaseTest extends TestCase
{
  private FavoriteRepositoryMock $favoriteRepositoryMock;
  private FavoriteAddUseCase $favoriteAddUseCase;

  protected function setUp(): void
  {
    parent::setUp();
    
    $this->favoriteRepositoryMock = new FavoriteRepositoryMock();
    $this->favoriteAddUseCase = new FavoriteAddUseCase($this->favoriteRepositoryMock);
  }

  public function test_add_new_favorite_successfully(): void
  {
    $userId = 1;
    $movieId = 123;
    $movieTitle = 'Inception';
    $genreIds = [1, 2, 3];
    
    $this->favoriteAddUseCase->execute($userId, $movieId, $movieTitle, $genreIds);
    
    $savedFavorites = $this->favoriteRepositoryMock->getFavorites();
    $this->assertCount(1, $savedFavorites);
    
    $favorite = $savedFavorites[0];
    $this->assertEquals($userId, $favorite->getUserId());
    $this->assertEquals($movieId, $favorite->getMovieId());
    $this->assertEquals($movieTitle, $favorite->getMovieTitle());
    $this->assertEquals($genreIds, $favorite->getGenreIds());
  }

  public function test_add_existing_favorite_throws_exception(): void
  {
    $userId = 1;
    $movieId = 123;
    $movieTitle = 'Inception';
    $genreIds = [1, 2, 3];
    
    $this->favoriteAddUseCase->execute($userId, $movieId, $movieTitle, $genreIds);
    
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('Filme já está nos favoritos.');
    
    $this->favoriteAddUseCase->execute($userId, $movieId, $movieTitle, $genreIds);
    
    $savedFavorites = $this->favoriteRepositoryMock->getFavorites();
    $this->assertCount(1, $savedFavorites);
  }

  protected function tearDown(): void
  {
    $this->favoriteRepositoryMock->clear();
    parent::tearDown();
  }
}