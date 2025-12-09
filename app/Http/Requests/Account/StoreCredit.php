<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class StoreCredit extends FormRequest {

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
            'subtotal' => 'required|numeric',
            'totalrate' => 'required|numeric',
            'discount' => 'required|numeric',
            'total' => 'required|numeric',
            'account_id' => 'required|numeric',
            'day' => 'required|date',
            'store_id' => 'required|exists:stores,id',
            'nr_requisicao' => 'required',
            'nr_factura' => 'required',
        ];
    }

}
