<?php

namespace App\Infra\Repositories;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
  public function findByEmail(string $email): ?User
  {
    $record = DB::table('users')
        ->where('email', $email)
        ->first();

    if (!$record) {
        return null;
    }

    return (new User())
        ->setId($record->id)
        ->setName($record->name)
        ->setEmail($record->email)
        ->setPassword($record->password);
  }

  public function save(User $user): void
  {
      DB::table('users')->insert([
          'name' => $user->getName(),
          'email' => $user->getEmail(),
          'password' => $user->getPassword(),
          'created_at' => now(),
          'updated_at' => now(),
      ]);
  }
}