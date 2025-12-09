<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompany extends FormRequest {

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
            'name' => 'required|min:3',
            'tel' => 'required|numeric',
            'fax' => 'nullable|numeric',
            'email' => 'required|email',
            'website' => 'nullable|url',
            'otherPhone' => 'nullable|numeric',
            'init' => 'required|date',
            'nuit' => 'required|numeric',
            'address' => 'required|min:3',
            'description' => 'nullable|min:3'
        ];
    }

}
