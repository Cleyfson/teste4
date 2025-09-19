<?php

namespace App\Application\UseCases\Movie;

use App\Domain\Contracts\MovieProviderInterface;

class MovieGetGenresUseCase
{
    public function __construct(protected MovieProviderInterface $provider) {}

    public function execute(): array
    {
        return $this->provider->getGenres();
    }
}
