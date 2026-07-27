<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchasePaymentUpdateRequest extends FormRequest
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

            'amount' => ['required', 'numeric', 'min:0.01'],

            'paid_at' => ['nullable', 'date'],

            'method' => ['nullable', 'string', 'max:80'],

            'reference' => ['nullable', 'string', 'max:255'],

            'notes' => ['nullable', 'string'],
        ];
    }
}
