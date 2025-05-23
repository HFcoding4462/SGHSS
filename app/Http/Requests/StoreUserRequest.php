<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:75',
            'cpf' => 'required|string',
            'idade' => 'required|integer|between:1,120',
            'sexo_id' => 'required|integer|exists:sexos,id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string'   
        ];
    }

    public function messages(): array {
        return [
            'required' => 'Campo :attribute obrigatorio',
        ];
    }
}
