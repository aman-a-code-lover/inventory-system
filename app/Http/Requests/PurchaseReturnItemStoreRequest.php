<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseReturnItemStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'purchase_return_id' => [
                'required',
                'exists:purchase_returns,id'
            ],

            'product_id' => [
                'required',
                'exists:products,id'
            ],

            'quantity' => [
                'required',
                'numeric',
                'min:0.01'
            ],

            'unit_price' => [
                'required',
                'numeric',
                'min:0'
            ],

            'reason' => [
                'nullable',
                'string'
            ],
        ];
    }
}
