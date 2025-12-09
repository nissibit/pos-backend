<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductChild extends FormRequest {

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
            'parent' => 'required|exists:products,id',
            'child' => 'required|exists:products,id',            
            'quantity' => 'required|numeric|min:0|not_in:0'
        ];
    }

}
