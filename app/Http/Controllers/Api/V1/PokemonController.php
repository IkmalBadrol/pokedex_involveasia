<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetPokemonsRequest;
use App\Http\Resources\PokemonResource;
use App\Services\PokemonService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PokemonController extends Controller
{
    public function __construct(
        private readonly PokemonService $pokemonService
    ) {}

    public function index(GetPokemonsRequest $request): AnonymousResourceCollection|JsonResponse
    {
        $result = $this->pokemonService->getPaginatedPokemons(
            page:  $request->page(),
            limit: $request->limit(),
        );

        return PokemonResource::collection($result['data'])
            ->additional([  
                'meta' => [
                    'total'       => $result['total'],
                    'page'        => $result['page'],
                    'limit'       => $result['limit'],
                    'total_pages' => $result['total_pages'],
                ],
            ]);
    }
}
