<?php

namespace App\Domain\Contracts;

interface MovieProviderInterface
{
    public function searchMovies(string $query): array;
    public function getGenres(): array;
}
