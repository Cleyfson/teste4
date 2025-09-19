<?php

namespace App\Application\UseCases\Auth;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use App\Domain\Repositories\UserRepositoryInterface;
use Exception;

class UserLogoutUseCase
{
    public function execute(): void
    {
        $token = JWTAuth::getToken();

        if ($token) {
            JWTAuth::invalidate($token);
        }
    }
}
