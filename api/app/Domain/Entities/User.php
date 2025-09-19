<?php

namespace App\Domain\Entities;
use Tymon\JWTAuth\Contracts\JWTSubject;

use Illuminate\Support\Facades\Hash;

class User implements JWTSubject
{
    private ?int $id = null;
    private string $name = '';
    private string $email = '';
    private string $password = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function verifyPassword(string $rawPassword): bool
    {
        return Hash::check($rawPassword, $this->password);
    }

    public function getJWTIdentifier()
    {
        return $this->id;
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
