<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UnitUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('units', 'code')->ignore($this->unit),
            ],

            'name' => [
                'required',
                'string',
                'max:80',
                Rule::unique('units', 'name')->ignore($this->unit),
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'precision' => [
                'required',
                'integer',
                'min:0',
                'max:6',
            ],
        ];
    }
}
