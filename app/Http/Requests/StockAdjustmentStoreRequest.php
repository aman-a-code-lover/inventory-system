<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StockAdjustmentStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reference_no' => [
                'required',
                'string',
                'max:120',
                'unique:stock_adjustments,reference_no',
            ],

            'warehouse_id' => [
                'nullable',
                'exists:warehouses,id',
            ],

            'reason' => [
                'nullable',
                'string',
            ],

            'total_adjusted' => [
                'required',
                'numeric',
                'min:0',
            ],

            'status' => [
                'required',
                Rule::in([
                    'pending',
                    'posted',
                    'cancelled',
                ]),
            ],
        ];
    }
}
