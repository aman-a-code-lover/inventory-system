<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BrandUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:150',
                Rule::unique('brands', 'name')->ignore($this->brand),
            ],

            'slug' => [
                'nullable',
                'string',
                'max:160',
                Rule::unique('brands', 'slug')->ignore($this->brand),
            ],

            'description' => [
                'nullable',
                'string',
            ],
        ];
    }
}
