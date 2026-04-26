<?php

namespace App\Contracts\Repositories;

interface PokemonRepositoryInterface
{
    public function getPaginatedList(int $limit, int $offset): array;

    public function getDetail(string $url): array;

    /**
     * @param  array<string>  $urls
     * @return array<array>
     */
    public function getManyDetails(array $urls): array;
}
