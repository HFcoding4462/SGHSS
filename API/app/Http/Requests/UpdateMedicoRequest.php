<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateMedicoRequest extends FormRequest
{
    public function authorize(): bool {
        $user = Auth::user();
        $medico = $this->route('medico');

        return $user->can('update', $medico);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = Auth::user();

        return [
            'name' => 'sometimes|max:75',
            'idade' => 'sometimes|integer|between:1,120',
            'sexo_id' => 'sometimes|integer|exists:sexos,id',
            'email' => [
                'sometimes', 'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'sometimes|string'
        ];
    }

    public function messages(): array {
        return [
            'integer' => 'Campo :attribute deve ser um número',
            'between' => 'Campo :attribute inválido',
            'unique' => 'Campo :attribute já existente',
            'exists' => 'Campo :attribute inválido',
            'string' => 'Campo :attribute precisa ser um campo de texto',
            'email' => 'Email inválido',
        ];
    }

    public function attributes(): array {
        return [
            'name' => 'nome (name)',
            'sexo_id' => 'sexo (sexo_id)',
            'password' => 'senha (password)',
        ];
    }
}
