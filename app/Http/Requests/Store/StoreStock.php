<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStock extends FormRequest {

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
        $request = $this->request->all();
//        dd($request['product_id']);
        return [
            'quantity' => 'required|numeric',
            'product_id' => [
                'required',
                'exists:products,id',
                Rule::unique('stocks')->where(function ($query) use($request) {
                            return $query->where('store_id', $request['store_id'])->where('product_id', $request['product_id']);
                        })
            ],
            'store_id' => 'required|exists:stores,id',
            'description' => 'nullable|min:2',
        ];
    }

    public function messages() {
        return [
            'unique' => 'O produto existe no armazem seleccionado.'
        ];
    }

}
