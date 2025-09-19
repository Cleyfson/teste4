<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavoriteStoreRequest;
use App\Application\UseCases\Favorite\FavoriteAddUseCase;
use App\Application\UseCases\Favorite\FavoriteListUseCase;
use Illuminate\Http\Request;
use Exception;

class FavoriteController extends Controller
{
  public function __construct(
    protected FavoriteAddUseCase $FavoriteAddUseCase,
    protected FavoriteListUseCase $FavoriteListUseCase,
  ) {}

  public function store(FavoriteStoreRequest $request)
  {
    try {
      $this->FavoriteAddUseCase->execute(
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

  public function index(Request $request)
  {
    try {
      $userId = auth()->id();
      $genreFilter = $request->query('genre_id');

      $favorites = $this->FavoriteListUseCase->execute($userId, $genreFilter);

      return response()->json(['favorites' => $favorites]);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }
}