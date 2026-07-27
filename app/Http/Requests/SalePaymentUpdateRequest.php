<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalePaymentUpdateRequest extends FormRequest
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

            'amount' => [
                'required',
                'numeric',
                'min:0',
            ],

            'paid_at' => [
                'nullable',
                'date',
            ],

            'method' => [
                'nullable',
                'string',
                'max:80',
            ],

            'reference' => [
                'nullable',
                'string',
                'max:255',
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
