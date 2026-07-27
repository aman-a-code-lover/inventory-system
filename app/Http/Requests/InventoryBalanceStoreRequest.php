<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryBalanceStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'product_id' => [
                'required',
                'exists:products,id',
            ],

            'warehouse_id' => [
                'required',
                'exists:warehouses,id',
            ],

            'quantity' => [
                'required',
                'numeric',
                'min:0',
            ],

            'reserved_quantity' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'last_movement_at' => [
                'nullable',
                'date',
            ],

        ];
    }
}
