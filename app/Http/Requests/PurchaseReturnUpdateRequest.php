<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseReturnUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'purchase_id' => ['nullable', 'exists:purchases,id'],

            'supplier_id' => ['nullable', 'exists:suppliers,id'],

            'reference_no' => [
                'required',
                'string',
                'max:120',
                Rule::unique('purchase_returns')
                    ->ignore($this->purchaseReturn),
            ],

            'total_amount' => ['required', 'numeric', 'min:0'],

            'return_date' => ['required', 'date'],

            'notes' => ['nullable', 'string'],
        ];
    }
}
