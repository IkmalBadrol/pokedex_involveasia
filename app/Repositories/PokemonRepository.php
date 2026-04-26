<?php

namespace App\Repositories;

use App\Contracts\Repositories\PokemonRepositoryInterface;
use App\Exceptions\PokemonApiException;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

class PokemonRepository implements PokemonRepositoryInterface
{
    private string $baseUrl;
    private int $timeout;

    public function __construct()
    {
        $this->baseUrl = config('pokeapi.base_url');
        $this->timeout = config('pokeapi.timeout');
    }

    public function getPaginatedList(int $limit, int $offset): array
    {
        $response = Http::timeout($this->timeout)
            ->get("{$this->baseUrl}/pokemon", [
                'limit'  => $limit,
                'offset' => $offset,
            ]);

        if ($response->failed()) {
            throw new PokemonApiException(
                "PokeAPI list endpoint returned HTTP {$response->status()}"
            );
        }

        return $response->json();
    }

    public function getDetail(string $url): array
    {
        $response = Http::timeout($this->timeout)->get($url);

        if ($response->failed()) {
            throw new PokemonApiException("Failed to fetch Pokémon detail from {$url}");
        }

        return $response->json();
    }

    /**
     * Fetch multiple Pokémon detail URLs concurrently using HTTP pooling.
     *
     * @param  array<string>  $urls
     * @return array<array>
     */
    public function getManyDetails(array $urls): array
    {
        $responses = Http::pool(function (Pool $pool) use ($urls) {
            return array_map(
                fn (string $url) => $pool->timeout($this->timeout)->get($url),
                $urls
            );
        });

        return array_map(function ($response) {
            if ($response instanceof \Throwable) {
                throw new PokemonApiException('Failed to connect to PokeAPI: ' . $response->getMessage());
            }

            if ($response->failed()) {
                throw new PokemonApiException('Failed to fetch a Pokémon detail in pool request');
            }

            return $response->json();
        }, $responses);
    }
}
