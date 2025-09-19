<?php

namespace App\Application\UseCases\Auth;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Entities\User;
use Exception;

class RegisterUserUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $name, string $email, string $password): User
    {
        if ($this->userRepository->findByEmail($email)) {
            throw new Exception('E-mail já está em uso.');
        }

        $user = (new User())
            ->setName($name)
            ->setEmail($email)
            ->setPassword(bcrypt($password));

        $this->userRepository->save($user);

        return $user;
    }
}
