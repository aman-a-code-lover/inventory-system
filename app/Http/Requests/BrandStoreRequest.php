<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150', 'unique:brands,name'],
            'slug' => ['nullable', 'string', 'max:160', 'unique:brands,slug'],
            'description' => ['nullable', 'string'],
        ];
    }
}
