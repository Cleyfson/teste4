<?php

namespace App\Application\UseCases\Favorite;

use App\Domain\Repositories\FavoriteRepositoryInterface;

class FavoriteListUseCase
{
    public function __construct(
        private FavoriteRepositoryInterface $repository
    ) {}

    public function execute(int $userId, ?int $genreFilter = null): array
    {
        return $this->repository->listByUser($userId, $genreFilter);
    }
}
