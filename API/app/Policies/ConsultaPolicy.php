<?php

namespace App\Policies;

use App\Models\Consulta;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Auth\Access\Response;

class ConsultaPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Consulta $consulta): bool
    {
        if ($user->role_id == UserRole::ADMINISTRADOR) {
            return true;
        } else if ($user->role_id == UserRole::MEDICO) {
            return $consulta->medico_id == $user->id;
        }

        return $consulta->paciente_id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Consulta $consulta): bool
    {
        switch($user->role_id) {
            case UserRole::ADMINISTRADOR:
                return true;
                break;
            case UserRole::MEDICO:
                return $user->id == $consulta->medico_id;
                break;
            case UserRole::PACIENTE:
                return $user->id == $consulta->paciente_id;
                break;
        }

        return false;
    }
}
