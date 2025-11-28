<?php

namespace App\Http\Requests\Server;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoice extends FormRequest {

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
            'number' => 'required',
            'subtotal' => 'required|numeric',
            'totalrate' => 'required|numeric',
            'discount' => 'required|numeric',
            'total' => 'required|numeric',
            'account_id' => 'required|numeric',
            'day' => 'required|date',
        ];
    }

}
