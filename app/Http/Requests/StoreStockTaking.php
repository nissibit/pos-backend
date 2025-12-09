<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockTaking extends FormRequest {

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
            'starttime' => 'required|datetime',
            'endtime' => 'nullable|datetime',
            'store_id' => 'required|exists:stores,id',
            'description' => 'nullable|min:3'
        ];
    }

}
