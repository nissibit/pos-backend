<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class StoreFactura extends FormRequest {

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

    public function attributes() {
        return [
            'customer_id' => __('messages.sale.customer_id'),
            'customer_name' =>  __('messages.sale.customer_name'),
            'customer_phone' =>  __('messages.sale.customer_phone'),
            'customer_nuit' =>  __('messages.sale.customer_nuit'),
            'customer_address' =>  __('messages.sale.customer_address'),
            'subtotal' =>  __('messages.sale.subtotal'),
            'totalrate' =>  __('messages.sale.totalrate'),
            'discount' =>  __('messages.sale.discount'),
            'total' =>  __('messages.sale.total'),
            'day' =>  __('messages.sale.day'),
            'store_id' =>  __('messages.sale.store_id'),
        ];
    }
}
