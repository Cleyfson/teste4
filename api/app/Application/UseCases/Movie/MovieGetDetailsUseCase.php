<?php

namespace App\Application\UseCases\Movie;

use App\Domain\Contracts\MovieProviderInterface;

class MovieGetDetailsUseCase
{
    public function __construct(
        protected MovieProviderInterface $movieProvider
    ) {}

    public function execute(int $movieId): array
    {
        return $this->movieProvider->getMovieDetails($movieId);
    }
}
