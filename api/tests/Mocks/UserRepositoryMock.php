<?php

namespace Tests\Mocks;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;

class UserRepositoryMock implements UserRepositoryInterface
{
    private array $users = [];
    private int $nextId = 1;

    public function findByEmail(string $email): ?User
    {
        foreach ($this->users as $user) {
            if ($user->getEmail() === $email) {
                return $user;
            }
        }
        
        return null;
    }

    public function save(User $user): void
    {
        if ($user->getId() === null) {
            $user->setId($this->nextId++);
            $this->users[] = $user;
        } else {
            foreach ($this->users as $key => $existingUser) {
                if ($existingUser->getId() === $user->getId()) {
                    $this->users[$key] = $user;
                    break;
                }
            }
        }
    }

    public function getUsers(): array
    {
        return $this->users;
    }

    public function clear(): void
    {
        $this->users = [];
        $this->nextId = 1;
    }
}