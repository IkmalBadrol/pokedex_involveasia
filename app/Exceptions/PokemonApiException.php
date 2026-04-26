<?php

namespace App\Exceptions;

use RuntimeException;

class PokemonApiException extends RuntimeException
{
    public function __construct(string $message = 'Failed to fetch Pokémon data from upstream API', int $code = 502)
    {
        parent::__construct($message, $code);
    }
}
