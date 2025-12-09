<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomer extends FormRequest {

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
            'fullname' => 'required|min:3',
            'type' => 'required',
            'nuit' => 'required|min:3',
            'document_type' => 'nullable',
            'document_number' => 'required_unless:document_type,""',
            'phone_nr' => 'required|max:9',
            'phone_nr_2' => 'nullable|max:9',
            'email' => 'nullable|email',
            'address' => 'required',
            'description' => 'nullable|min:2',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
        return [
            'fullname' => __('messages.sidebar.customer'),
        ];
    }

}
