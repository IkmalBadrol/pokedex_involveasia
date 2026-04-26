<?php

namespace App\Services;

use App\Contracts\Repositories\PokemonRepositoryInterface;
use App\DataTransferObjects\PokemonData;
use Illuminate\Support\Facades\Cache;

class PokemonService
{
    public function __construct(
        private readonly PokemonRepositoryInterface $pokemonRepository
    ) {}

    /**
     * @return array{data: PokemonData[], total: int, page: int, limit: int, total_pages: int}
     */
    public function getPaginatedPokemons(int $page, int $limit): array
    {
        $offset = ($page - 1) * $limit;
        $cacheKey = "pokemons:page:{$page}:limit:{$limit}";
        $cacheTtl = config('pokeapi.cache_ttl');

        return Cache::remember($cacheKey, $cacheTtl, function () use ($limit, $offset, $page) {
            $listResponse = $this->pokemonRepository->getPaginatedList($limit, $offset);

            $urls = array_column($listResponse['results'] ?? [], 'url');
            $details = $this->pokemonRepository->getManyDetails($urls);

            $pokemons = array_map(
                fn (array $detail) => PokemonData::fromApiResponse($detail),
                $details
            );

            return [
                'data'        => $pokemons,
                'total'       => $listResponse['count'] ?? 0,
                'page'        => $page,
                'limit'       => $limit,
                'total_pages' => (int) ceil(($listResponse['count'] ?? 0) / $limit),
            ];
        });
    }
}
