<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class StoreCreditNote extends FormRequest {

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
            'payment_id' => 'required|exists:payments,id',
            'total' => 'required|numeric',
            'reason' => 'required',
            'return_money' => 'required',
            'description' => 'nullable|required_if:reason,OUTRO|min:3'
        ];
    }

}
