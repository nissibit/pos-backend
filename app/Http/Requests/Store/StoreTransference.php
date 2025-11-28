<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTransference extends FormRequest {

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
            'from' => 'required|exists:stores,id',
            'to' => 'required|exists:stores,id',
            'motive' => 'required|min:2',
            'day' => 'required|date',
            'description' => 'nullable|min:2'
        ];
    }
    
    public function attributes() {
        return [
            'from' => 'Origem',
            'to' => 'Destino',
            'motive' => 'Motivo',
            'day' => 'Data',
            'description' => 'Descricao'
        ];
    }

}
