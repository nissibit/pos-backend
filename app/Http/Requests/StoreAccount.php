<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Validator;
class StoreAccount extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'bank_id' => 'required',
            'number' => [
                'required', 
                'string',
                'min:6',
                'max:30',
                Rule::unique('accounts')->where(function ($query) use($request) {
                    return $query->where('bank_id', $request->bank_id)
                    ->where('bank_id', $request->bank_id)->count();
                }),
            ],
            'description' => 'nullable|min:3'
        ];
    }
}
