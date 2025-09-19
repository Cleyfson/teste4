<?php

namespace App\Infra\Repositories;

use App\Domain\Entities\Favorite;
use App\Domain\Repositories\FavoriteRepositoryInterface;
use Illuminate\Support\Facades\DB;

class FavoriteRepository implements FavoriteRepositoryInterface
{
  public function add(Favorite $favorite): void
  {
    DB::table('favorites')->insert([
      'user_id' => $favorite->getUserId(),
      'movie_id' => $favorite->getMovieId(),
      'movie_title' => $favorite->getMovieTitle(),
      'genre_ids' => json_encode($favorite->getGenreIds()),
      'created_at' => now(),
      'updated_at' => now(),
    ]);
  }

  public function exists(int $userId, int $movieId): bool
  {
    return DB::table('favorites')
      ->where('user_id', $userId)
      ->where('movie_id', $movieId)
      ->exists();
  }
}
