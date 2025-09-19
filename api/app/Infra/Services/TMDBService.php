<?php

namespace App\Infra\Services;

use Illuminate\Support\Facades\Http;
use App\Domain\Contracts\MovieProviderInterface;

class TMDBService implements MovieProviderInterface
{
  protected string $apiUrl;
  protected string $apiKey;

  public function __construct()
  {
    $this->apiUrl = config('services.tmdb.base_url');
    $this->apiKey = config('services.tmdb.api_key');
  }

  private function makeRequest(string $method, string $endpoint, array $params = []): \Illuminate\Http\Client\Response
  {
    $headers = [
      'Authorization' => 'Bearer ' . $this->apiKey,
      'accept' => 'application/json',
    ];

    return Http::withHeaders($headers)->$method("{$this->apiUrl}/{$endpoint}", $params);
  }

  public function searchMovies(string $query): array
  {
    $response = $this->makeRequest('get', 'search/movie', [
      'query' => $query,
      'language' => 'pt-BR',
    ]);

    if ($response->successful()) {
      return $response->json()['results'];
    }

    throw new \Exception("Erro ao buscar filmes no TMDB.");
  }

  public function getGenres(): array
  {
    $response = $this->makeRequest('get', 'genre/movie/list', [
      'language' => 'pt-BR',
    ]);

    if ($response->successful()) {
      return $response->json()['genres'];
    }

    throw new \Exception("Erro ao buscar gêneros no TMDB.");
  }
}
