<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuotation extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'customer_id' => 'nullable',
            'customer_name' => 'nullable',
            'customer_phone' => 'nullable',
            'customer_nuit' => 'nullable',
            'customer_address' => 'nullable',
            'subtotal' => 'required|numeric',
            'totalrate' => 'required|numeric',
            'discount' => 'required|numeric',
            'total' => 'required|numeric',
            'day' => 'required|date',
            'store_id' => 'required|exists:stores,id',
        ];
    }

}
