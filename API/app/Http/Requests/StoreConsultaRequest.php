<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRole;

class StoreConsultaRequest extends FormRequest
{
    public function authorize(): bool {
        $user = Auth::user();
        return ($user->role_id == UserRole::PACIENTE || $user->role_id == UserRole::ADMINISTRADOR);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = Auth::user();
        $validations = [
            "medico_id" => "required|integer|exists:users,id",
            "data" => "required|date|unique:consultas,data,NULL,NULL,deleted_at,NULL"
        ];

        if ($user->role_id == UserRole::ADMINISTRADOR) {
            $validations["paciente_id"] = "sometimes|integer|exists:users,id";
        }

        return $validations;
    }

    public function messages(): array {
        return [
            "required" => "Campo :attribute obrigatorio",
            "integer" => "Campo :attribute inválido",
            "exists" => "Campo :attribute inválido",
            "date" => "Data inválida",
            "data.unique" => "Data indisponivel"
        ];
    }
}
