<?php

namespace App\Http\Requests\MoneyFlow;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMoneyFlow extends FormRequest {

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
            'amount' => 'required|numeric|min:0|not_in:0',
            'type' => [
                'required',
                Rule::in(\App\Base::cashFlowType())
            ],
            'reason' => 'required',
            'fund_id' => 'required|exists:funds,id',
        ];
    }

}
