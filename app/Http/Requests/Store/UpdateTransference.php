<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransference extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'from' => 'required|exists:stores,id',
            'to' => 'required|exists:stores,id',
            'product_id' => 'required|exists:products,id',
            'quantity_from' => 'required',
            'quantity_to' => 'required',
            'quantity' => 'required|numeric',
            'motive' => 'required|min:2',
            'day' => 'required|date',
            'description' => 'nullable|min:2',
        ];
    }

}
