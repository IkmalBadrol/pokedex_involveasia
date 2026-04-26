<?php

namespace App\Providers;

use App\Contracts\Repositories\PokemonRepositoryInterface;
use App\Repositories\PokemonRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PokemonRepositoryInterface::class, PokemonRepository::class);
    }
}
