<?php

namespace App\Http\Requests\CashFlow;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCashFlow extends FormRequest {

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
            'cashier_id' => 'required|exists:cashiers,id',
        ];
    }

    public function attributes() {
        return [
            'amount' => __('messages.cashflow.amount'),
            'type' => __('messages.cashflow.type'),
            'reason' => __('messages.cashflow.reason'),
            'cashier_id' => __('messages.cashflow.cashier_id'),
        ];
    }

}
