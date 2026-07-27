<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductSupplierUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'product_id' => [
                'required',
                'exists:products,id',
            ],

            'supplier_id' => [
                'required',
                'exists:suppliers,id',
            ],

            'supplier_sku' => [
                'nullable',
                'string',
                'max:120',
            ],

            'supplier_cost' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'lead_time_days' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'is_primary' => [
                'nullable',
                'boolean',
            ],
        ];
    }
}
