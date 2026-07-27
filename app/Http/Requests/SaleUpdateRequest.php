<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaleUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'customer_id' => [
                'nullable',
                'exists:customers,id',
            ],

            'reference_no' => [
                'required',
                'string',
                'max:120',
                Rule::unique('sales', 'reference_no')
                    ->ignore($this->sale),
            ],

            'status' => [
                'required',
                Rule::in([
                    'draft',
                    'completed',
                    'cancelled',
                ]),
            ],

            'total_amount' => [
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

            'paid_amount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'sale_date' => [
                'required',
                'date',
            ],

            'due_date' => [
                'nullable',
                'date',
                'after_or_equal:sale_date',
            ],

            'warehouse_id' => [
                'nullable',
                'exists:warehouses,id',
            ],

            'created_by' => [
                'nullable',
                'exists:users,id',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ];
    }
}
