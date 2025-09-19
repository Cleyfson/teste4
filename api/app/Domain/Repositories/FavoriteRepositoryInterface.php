<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Favorite;

interface FavoriteRepositoryInterface
{
  public function add(Favorite $favorite): void;
  public function listByUser(int $userId, ?int $genreFilter = null): array;
  public function exists(int $userId, int $movieId): bool;
  public function remove(int $userId, int $movieId): void;
}
