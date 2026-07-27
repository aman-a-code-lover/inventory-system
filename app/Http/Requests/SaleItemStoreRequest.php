<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleItemStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'sale_id' => [
                'required',
                'exists:sales,id',
            ],

            'product_id' => [
                'required',
                'exists:products,id',
            ],

            'quantity' => [
                'required',
                'numeric',
                'min:0',
            ],

            'unit_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'tax_amount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'discount_amount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'lot_number' => [
                'nullable',
                'string',
                'max:120',
            ],

            'expiry_date' => [
                'nullable',
                'date',
            ],
        ];
    }
}
