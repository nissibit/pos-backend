<?php

namespace App\Http\Requests\Reinforcement;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReinforcement extends FormRequest {

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
            'amount' => 'required|numeric',
            'fund_id' => 'required|exists:funds,id',
            'description' => 'nullable|min:2'
        ];
    }

}
