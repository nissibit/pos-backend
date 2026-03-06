<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => 'required',
            'password' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'login.required' => 'Indique o seu email ou nome de utilizador.',
            'password.required' => 'A palavra-passe é obrigatória.',
        ];
    }
}
