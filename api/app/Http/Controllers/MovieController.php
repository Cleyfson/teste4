<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Movie\MovieSearchUseCase;
use App\Application\UseCases\Movie\MovieGetGenresUseCase;
use Illuminate\Http\Request;

class MovieController extends Controller
{
  public function __construct(
    protected MovieSearchUseCase $MovieSearchUseCase,
    protected MovieGetGenresUseCase $MovieGetGenresUseCase,
  ) {}

  public function search(Request $request)
  {
    try {
      $query = $request->query('q');
  
      if (!$query) {
        return response()->json([
          'error' => 'Parâmetro de busca obrigatório'
        ], 422);
      }
  
      $movies = $this->MovieSearchUseCase->execute($query);
      return response()->json($movies);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }

  public function genres()
  {
    try {
      $genres = $this->MovieGetGenresUseCase->execute();
      return response()->json($genres);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }
}
