<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Auth\UserRegisterUseCase;
use App\Application\UseCases\Auth\UserLoginUseCase;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Exception;

class AuthController extends Controller
{
  protected UserRegisterUseCase $UserRegisterUseCase;
  protected UserLoginUseCase $UserLoginUseCase;

  public function __construct(
    UserRegisterUseCase $UserRegisterUseCase,
    UserLoginUseCase $UserLoginUseCase
  )
  {
    $this->UserRegisterUseCase = $UserRegisterUseCase;
    $this->UserLoginUseCase = $UserLoginUseCase;
  }

  public function login(UserLoginRequest $request)
  {
    try {
      $data = $this->UserLoginUseCase->execute(
        $request->email, 
        $request->password
      );
      
      return response()->json([
          'access_token' => $data,
          'token_type' => 'bearer',
          'expires_in' => auth()->factory()->getTTL() * 60
      ]);
        
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 401);
    }
  }

  public function register(UserRegisterRequest $request)
  {
    try {
      $user = $this->UserRegisterUseCase->execute(
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
