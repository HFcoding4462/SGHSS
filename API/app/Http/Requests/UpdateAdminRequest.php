<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateAdminRequest extends FormRequest
{
    public function authorize(): bool {
        $user = Auth::user();
        $admin = $this->route('admin');

        return $user->can('update', $admin);
    }

    public function rules(): array
    {
        $user = Auth::user();

        return [
            'name' => 'sometimes|max:75',
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
