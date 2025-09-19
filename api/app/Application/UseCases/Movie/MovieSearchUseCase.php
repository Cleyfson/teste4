<?php

namespace App\Application\UseCases\Movie;

use App\Domain\Contracts\MovieProviderInterface;

class MovieSearchUseCase
{
    public function __construct(protected MovieProviderInterface $provider) {}

    public function execute(string $query): array
    {
        return $this->provider->searchMovies($query);
    }
}
