<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Favorite;

interface FavoriteRepositoryInterface
{
  public function add(Favorite $favorite): void;
  public function exists(int $userId, int $movieId): bool;
}
