<?php

namespace App\Application\UseCases\Favorite;

use App\Domain\Repositories\FavoriteRepositoryInterface;
use App\Domain\Contracts\MovieProviderInterface;
use App\Domain\Entities\Favorite;
use Exception;

class FavoriteAddUseCase
{
    public function __construct(
        private FavoriteRepositoryInterface $repository,
        protected MovieProviderInterface $provider
    ) {}

    public function execute(int $userId, int $movieId): void
    {
      if ($this->repository->exists($userId, $movieId)) {
          throw new Exception("Filme já está nos favoritos.");
      }

      $movie = $this->provider->getMovieDetails($movieId);

      $genreIds = array_map(fn($genre) => $genre['id'], $movie['genres'] ?? []);

      $favorite = (new Favorite())
          ->setUserId($userId)
          ->setMovieId($movieId)
          ->setMovieTitle($movie['title'] ?? '')
          ->setOriginalTitle($movie['original_title'] ?? null)
          ->setOverview($movie['overview'] ?? null)
          ->setPosterPath($movie['poster_path'] ?? null)
          ->setReleaseDate($movie['release_date'] ?? null)
          ->setGenreIds($genreIds);

      $this->repository->add($favorite);
    }
}
