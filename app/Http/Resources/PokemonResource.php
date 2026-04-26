<?php

namespace App\Http\Resources;

use App\DataTransferObjects\PokemonData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin PokemonData */
class PokemonResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name'   => $this->name,
            'image'  => $this->image,
            'types'  => $this->types,
            'height' => $this->height,
            'weight' => $this->weight,
        ];
    }
}
