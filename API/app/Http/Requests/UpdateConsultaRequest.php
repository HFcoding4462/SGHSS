<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRole;
use Illuminate\Validation\Rule;

class UpdateConsultaRequest extends FormRequest
{
    public function authorize(): bool {
        $user = Auth::user();
        $consulta = $this->route('consulta');

        return $user->can('update', $consulta);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = Auth::user();
        $consulta = $this->route('consulta');

        $validations = [
            "medico_id" => [
                "sometimes", "integer",
                Rule::exists('users', 'id')
                    ->where('role_id', UserRole::MEDICO)
                    ->whereNull('deleted_at')
            ],

            "data" => [
                'sometimes', 'date',
                Rule::unique('consultas', 'data')
                    ->ignore($consulta->id)
                    ->whereNull('deleted_at'),
            ]
        ];

        if ($user->role_id == UserRole::ADMINISTRADOR) {
            $validations["paciente_id"] = "sometimes|integer|exists:users,id";
            $validations["resultado"] = "sometimes|string";
        } else if ($user->role_id == UserRole::MEDICO) {
            $validations["resultado"] = "required|string";
        }

        return $validations;
    }

    public function messages(): array {
        return [
            "required" => "Campo :attribute obrigatorio",
            "integer" => "Campo :attribute inválido",
            "exists" => "Campo :attribute inválido",
            "data" => "Data inválida - Formato MM/DD/YYYY",
            "data.unique" => "Data indisponivel"
        ];
    }
}
