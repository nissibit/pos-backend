<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCreditNote extends FormRequest {

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
            'topay' => 'required|numeric',
            'total' => 'required|numeric',
            'change' => 'required|numeric',
            'day' => 'required|date',
            'payment_id' => 'nullable',
            'payment_type' => 'nullable'
        ];
    }

}
