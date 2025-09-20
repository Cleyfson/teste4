<?php

namespace Tests\Mocks;

use App\Domain\Contracts\MovieProviderInterface;

class MovieProviderMock implements MovieProviderInterface
{
    private array $movies = [];

    public function setMovieDetails(int $movieId, array $details): void
    {
        $this->movies[$movieId] = $details;
    }

    public function getMovieDetails(int $movieId): array
    {
        return $this->movies[$movieId] ?? [];
    }

    public function searchMovies(string $query): array
    {
        return [];
    }

    public function getGenres(): array
    {
        return [];
    }
}
