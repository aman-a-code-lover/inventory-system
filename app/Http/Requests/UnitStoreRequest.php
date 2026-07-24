<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:20', 'unique:units,code'],
            'name' => ['required', 'string', 'max:80', 'unique:units,name'],
            'description' => ['nullable', 'string'],
            'precision' => ['required', 'integer', 'min:0', 'max:6'],
        ];
    }
}
