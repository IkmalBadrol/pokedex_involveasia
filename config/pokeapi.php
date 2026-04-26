<?php

return [
    'base_url' => env('POKEAPI_BASE_URL', 'https://pokeapi.co/api/v2'),
    'timeout'  => (int) env('POKEAPI_TIMEOUT', 15),
    'cache_ttl' => (int) env('POKEAPI_CACHE_TTL', 3600),
];
