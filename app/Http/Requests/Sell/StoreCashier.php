<?php

namespace App\Http\Requests\Sell;

use Illuminate\Foundation\Http\FormRequest;

class StoreCashier extends FormRequest {

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
            'user_id' => 'required|exists:users,id',
            'startime' => 'required|date',
            'endtime' => 'nullable|date',
            'initial' => 'required|numeric',
            'informed' => 'nullable|numeric',
            'present' => 'nullable|numeric',
            'missing' => 'nullable|numeric',
            'description' => 'nullable|min:3',
        ];
    }

    public function attributes() {
        return [
            'user_id' => __('messages.user_id'),
            'startime' => __('messages.startime'),
            'endtime' => __('messages.endtime'),
            'initial' => __('messages.initial'),
            'informed' => __('messages.informed'),
            'present' => __('messages.present'),
            'missing' => __('messages.missing'),
            'description' => __('messages.description'),
        ];
    }

}
