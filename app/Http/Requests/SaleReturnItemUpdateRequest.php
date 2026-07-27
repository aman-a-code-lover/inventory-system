<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleReturnItemUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'sale_return_id' => [
                'required',
                'exists:sale_returns,id',
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

            'reason' => [
                'nullable',
                'string',
            ],

        ];
    }
}
