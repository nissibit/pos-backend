<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEntry extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quantity' => 'required|numeric',
            'old_price' => 'required|numeric',
            'buying_price' => 'required|numeric',
            'current_price' => 'required|numeric',
            'product_id' => 'required|exists:products,id',
            'store_id' => 'required|exists:stores,id',
            'invoice_id' => 'required|exists:invoices,id',
            'description' => 'nullable|min:2'
        ];
    }
}
