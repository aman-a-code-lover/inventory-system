<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sku' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('products', 'sku')->ignore($this->product),
            ],

            'barcode' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('products', 'barcode')->ignore($this->product),
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'brand_id' => [
                'nullable',
                'exists:brands,id',
            ],

            'category_id' => [
                'nullable',
                'exists:categories,id',
            ],

            'unit_id' => [
                'nullable',
                'exists:units,id',
            ],

            'cost_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'sell_price' => [
                'required',
                'numeric',
                'gte:cost_price',
            ],

            'reorder_level' => [
                'required',
                'numeric',
                'min:0',
            ],

            'is_active' => [
                'required',
                'boolean',
            ],
        ];
    }
}
