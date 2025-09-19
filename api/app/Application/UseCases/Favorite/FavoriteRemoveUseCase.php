<?php

namespace App\Application\UseCases\Favorite;

use App\Domain\Repositories\FavoriteRepositoryInterface;

class FavoriteRemoveUseCase
{
    public function __construct(
        private FavoriteRepositoryInterface $repository
    ) {}

    public function execute(int $userId, int $movieId): void
    {
        $this->repository->remove($userId, $movieId);
    }
}
