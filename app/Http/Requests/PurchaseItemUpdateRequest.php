<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseItemUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'purchase_id' => ['required', 'exists:purchases,id'],
            'product_id' => ['required', 'exists:products,id'],

            'quantity' => ['required', 'numeric', 'min:0.0001'],
            'unit_price' => ['required', 'numeric', 'min:0'],

            'tax_amount' => ['required', 'numeric', 'min:0'],
            'discount_amount' => ['required', 'numeric', 'min:0'],
            'line_total' => ['required', 'numeric', 'min:0'],

            'lot_number' => ['nullable', 'string', 'max:120'],
            'expiry_date' => ['nullable', 'date'],
        ];
    }
}
