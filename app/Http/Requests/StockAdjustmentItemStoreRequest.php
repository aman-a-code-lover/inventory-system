<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockAdjustmentItemStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'stock_adjustment_id' => [
                'required',
                'exists:stock_adjustments,id',
            ],

            'product_id' => [
                'required',
                'exists:products,id',
            ],

            'quantity_before' => [
                'required',
                'numeric',
                'min:0',
            ],

            'quantity_after' => [
                'required',
                'numeric',
                'min:0',
            ],

            'adjustment_quantity' => [
                'required',
                'numeric',
            ],

            'reason' => [
                'nullable',
                'string',
            ],
        ];
    }
}
