<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaleStoreRequest extends FormRequest
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
                'unique:sales,reference_no',
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
            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.product_id' => [
                'required',
                'exists:products,id',
            ],

            'items.*.quantity' => [
                'required',
                'numeric',
                'gt:0',
            ],

            'items.*.unit_price' => [
                'required',
                'numeric',
                'min:0',
            ],
        ];
    }
}
