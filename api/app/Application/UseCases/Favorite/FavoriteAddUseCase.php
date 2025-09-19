<?php

namespace App\Application\UseCases\Favorite;

use App\Domain\Repositories\FavoriteRepositoryInterface;
use App\Domain\Entities\Favorite;
use Exception;

class FavoriteAddUseCase
{
  public function __construct(
    private FavoriteRepositoryInterface $repository
  ) {}

  public function execute(int $userId, int $movieId, string $movieTitle, array $genreIds): void
  {
    if ($this->repository->exists($userId, $movieId)) {
      throw new Exception("Filme já está nos favoritos.");
    }

    $favorite = (new Favorite())
      ->setUserId($userId)
      ->setMovieId($movieId)
      ->setMovieTitle($movieTitle)
      ->setGenreIdss($genreIds);

    $this->repository->add($favorite);
  }
}
