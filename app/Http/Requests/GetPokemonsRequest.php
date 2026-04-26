<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetPokemonsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page'  => ['sometimes', 'integer', 'min:1'],
            'limit' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ];
    }

    public function page(): int
    {
        return (int) $this->query('page', 1);
    }

    public function limit(): int
    {
        return (int) $this->query('limit', 20);
    }
}
