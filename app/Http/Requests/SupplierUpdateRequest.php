<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $supplier = $this->route('supplier');

        return [
            'name' => [
                'required',
                'string',
                'max:200',
                Rule::unique('suppliers', 'name')->ignore($supplier),
            ],

            'code' => [
                'nullable',
                'string',
                'max:80',
                Rule::unique('suppliers', 'code')->ignore($supplier),
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('suppliers', 'email')->ignore($supplier),
            ],

            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'website' => ['nullable', 'url', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:150'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
