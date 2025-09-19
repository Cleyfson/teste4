<?php

namespace Tests\Mocks;

use App\Domain\Entities\Favorite;
use App\Domain\Repositories\FavoriteRepositoryInterface;

class FavoriteRepositoryMock implements FavoriteRepositoryInterface
{
  private array $favorites = [];
  private int $nextId = 1;

  public function exists(int $userId, int $movieId): bool
  {
    if (empty($this->favorites)) {
      return false;
    }

    foreach ($this->favorites as $favorite) {
      if ($favorite->getUserId() === $userId && 
        $favorite->getMovieId() === $movieId) {
        return true;
      }
    }
    return false;
  }

  public function add(Favorite $favorite): void
  {

    $favorite->setId($this->nextId++);
    $this->favorites[] = $favorite;
  }

  public function listByUser(int $userId, ?int $genreFilter = null): array
  {
    return array_values(array_filter($this->favorites, function(Favorite $favorite) use ($userId, $genreFilter) {
      $matchesUser = $favorite->getUserId() === $userId;
      $matchesGenre = $genreFilter === null || in_array($genreFilter, $favorite->getGenreIds());
      return $matchesUser && $matchesGenre;
    }));
  }

  public function remove(int $userId, int $movieId): void
  {
    $this->favorites = array_values(array_filter($this->favorites, function(Favorite $favorite) use ($userId, $movieId) {
      return !($favorite->getUserId() === $userId && $favorite->getMovieId() === $movieId);
    }));
  }

  public function getFavorites(): array
  {
    return $this->favorites;
  }

  public function clear(): void
  {
    $this->favorites = [];
    $this->nextId = 1;
  }
}