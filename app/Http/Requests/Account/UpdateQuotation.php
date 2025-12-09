<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuotation extends FormRequest {

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
            'customer_id' => 'required',
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'subtotal' => 'required|numeric',
            'totalrate' => 'required|numeric',
            'discount' => 'required|numeric',
            'total' => 'required|numeric',
            'account_id' => 'required|numeric',
            'day' => 'required|date',
        ];
    }

}
