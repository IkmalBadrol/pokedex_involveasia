<?php

namespace App\DataTransferObjects;

final readonly class PokemonData
{
    public function __construct(
        public string $name,
        public ?string $image,
        public array $types,
        public int $height,
        public int $weight,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            name:   $data['name'],
            image:  $data['sprites']['other']['official-artwork']['front_default'] ?? null,
            types:  array_map(
                        fn (array $slot) => $slot['type']['name'],
                        $data['types'] ?? []
                    ),
            height: $data['height'] ?? 0,
            weight: $data['weight'] ?? 0,
        );
    }
}
