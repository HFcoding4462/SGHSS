<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool {
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
            'name' => 'required|max:75',
            'cpf' => 'required|string|unique:users,cpf|formato_cpf',
            'idade' => 'required|integer|between:1,120',
            'sexo_id' => 'required|integer|exists:sexos,id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string'   
        ];
    }

    public function messages(): array {
        return [
            'required' => 'Campo :attribute obrigatorio',
            'integer' => 'Campo :attribute deve ser um número',
            'between' => 'Campo :attribute inválido',
            'unique' => 'Campo :attribute já existente',
            'exists' => 'Campo :attribute inválido',
            'string' => 'Campo :attribute precisa ser um campo de texto',
            'email' => 'Email inválido',
            'formato_cpf' => 'Campo cpf não possui o formato válido de CPF (999.999.999-99).'
        ];
    }

    public function attributes(): array {
        return [
            'name' => 'nome',
            'sexo_id' => 'sexo',
            'password' => 'senha',
        ];
    }
}
