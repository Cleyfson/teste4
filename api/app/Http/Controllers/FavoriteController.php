<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavoriteStoreRequest;
use App\Application\UseCases\Favorite\FavoriteAddUseCase;
use Exception;

class FavoriteController extends Controller
{
  public function __construct(
    protected FavoriteAddUseCase $favoriteAddUseCase,
  ) {}

  public function store(FavoriteStoreRequest $request)
  {
    try {
      $this->favoriteAddUseCase->execute(
        auth()->id(),
        $request->movie_id,
        $request->movie_title,
        $request->genre_ids
      );

      return response()->json(['message' => 'Filme adicionado aos favoritos.'], 201);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }
}