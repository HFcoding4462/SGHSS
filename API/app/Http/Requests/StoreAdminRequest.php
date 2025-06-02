<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRole;
use App\Services\AdminService;

class StoreAdminRequest extends FormRequest
{
    public function authorize(): bool {
        $adminCount = (new AdminService)->all()->count();

        if ($adminCount == 0) {
            return true;
        }

        $user = Auth::user();
        return $user->role_id == UserRole::ADMINISTRADOR;
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
            'cpf' => 'required|string|unique:users,cpf,NULL,NULL,deleted_at,NULL|formato_cpf',
            'idade' => 'required|integer|between:1,120',
            'sexo_id' => 'required|integer|exists:sexos,id',
            'email' => 'required|email|unique:users,email,NULL,NULL,deleted_at,NULL',
            'password' => 'required|string'   
        ];
    }

    public function messages(): array {
        return [
            'required' => 'Campo :attribute obrigatorio',
            'integer' => 'Campo :attribute deve ser um número',
            'between' => 'Campo :attribute inválido',
            'unique' => 'Campo :attribute já cadastrado',
            'exists' => 'Campo :attribute inválido',
            'string' => 'Campo :attribute precisa ser um campo de texto',
            'email' => 'Email inválido',
            'formato_cpf' => 'Campo cpf não possui o formato válido de CPF (999.999.999-99).'
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
