<?php

namespace App\Http\Requests\Money;

use Illuminate\Foundation\Http\FormRequest;

class StoreFund extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
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
}
