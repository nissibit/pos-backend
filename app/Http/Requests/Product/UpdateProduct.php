<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProduct extends FormRequest {

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
            'barcode' => 'required',
            'othercode' => 'nullable|min:2',
            'name' => 'required|min:2',
            'label' => 'required|min:2',
            'category_id' => 'required|exists:categories,id',
            'unity_id' => 'required|exists:unities,id',
            'rate' => 'required|numeric',
            'price' => 'required|numeric',
            'buying' => 'required|numeric',
            'run_out' => 'required|numeric',
            'description' => 'nullable|min:2',
        ];
    }

}
