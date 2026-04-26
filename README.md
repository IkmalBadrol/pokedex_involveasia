# pokedex_involveasia
# Pokedex API — Laravel Backend

A RESTful Laravel API that proxies [PokeAPI](https://pokeapi.co) data with pagination, concurrent fetching, and response caching.

---

## Requirements

- PHP 8.2+
- Composer
- Node.js & NPM

---

## Setup

### 1. Clone the repository

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Environment setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure `.env`

Open `.env` and ensure these values are set:

```env
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite

CACHE_STORE=file

POKEAPI_BASE_URL=https://pokeapi.co/api/v2
POKEAPI_TIMEOUT=15
POKEAPI_CACHE_TTL=3600
```

### 5. Run database migrations

```bash
php artisan migrate
```

### 6. Start the server

```bash
php artisan serve
```

The API will be available at `http://localhost:8000`.

---

## API Endpoint

### Get Pokémon List

```
GET /api/pokemons?page=<number>&limit=<number>
```

| Parameter | Type    | Default | Description                  |
|-----------|---------|---------|------------------------------|
| `page`    | integer | `1`     | Page number (min: 1)         |
| `limit`   | integer | `20`    | Results per page (max: 100)  |

#### Example Request

```
GET http://localhost:8000/api/pokemons?page=1&limit=8
```

#### Example Response

```json
{
    "data": [
        {
            "name": "bulbasaur",
            "image": "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/1.png",
            "types": ["grass", "poison"],
            "height": 7,
            "weight": 69
        }
    ],
    "meta": {
        "total": 1302,
        "page": 1,
        "limit": 8,
        "total_pages": 163
    }
}
```
