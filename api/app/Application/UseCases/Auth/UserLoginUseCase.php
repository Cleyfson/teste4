<?php

namespace App\Application\UseCases\Auth;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use App\Domain\Repositories\UserRepositoryInterface;
use Exception;

class UserLoginUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $email, string $password): string
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user || !$user->verifyPassword($password)) {
            throw new \Exception("Credenciais inválidas.");
        }

        return JWTAuth::fromUser($user);
    }
}
