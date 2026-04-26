<?php

use App\Http\Controllers\Api\V1\PokemonController;
use Illuminate\Support\Facades\Route;

Route::get('/pokemons', [PokemonController::class, 'index']);
