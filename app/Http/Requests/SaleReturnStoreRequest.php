<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleReturnStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'sale_id' => [
                'nullable',
                'exists:sales,id',
            ],

            'customer_id' => [
                'nullable',
                'exists:customers,id',
            ],

            'reference_no' => [
                'required',
                'string',
                'max:120',
                'unique:sale_returns,reference_no',
            ],

            'total_amount' => [
                'required',
                'numeric',
                'min:0',
            ],

            'return_date' => [
                'required',
                'date',
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
