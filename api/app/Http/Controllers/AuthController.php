<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Auth\RegisterUserUseCase;
use App\Http\Requests\RegisterUserRequest;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Exception;

class AuthController extends Controller
{
  protected RegisterUserUseCase $registerUserUseCase;

  public function __construct(
    RegisterUserUseCase $registerUserUseCase    
  )
  {
    $this->registerUserUseCase = $registerUserUseCase;
  }

  public function register(RegisterUserRequest $request)
  {
    try {
      $user = $this->registerUserUseCase->execute(
        $request->name,
        $request->email,
        $request->password
      );

      return response()->json([
        'message' => 'Usuário registrado com sucesso!',
        'user' => $user
      ], 201);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }
}
