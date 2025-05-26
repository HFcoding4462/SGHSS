<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Auth\Access\Response;
use App\Services\MedicoService;

class UserPolicy
{
    public function view(User $user, User $model): bool {
        $medicoService = new MedicoService;

        switch($user->role_id) {
            case UserRole::ADMINISTRADOR:
                return true;
                break;
                
            case UserRole::MEDICO:
                $pacientes = $medicoService->getPacientes($user);
                return (bool) $pacientes->firstWhere('id', $model->id);
                break;

            case UserRole::PACIENTE:
                return $user->id == $model->id;
                break;
        }

        return false;
    }

   /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        if ($user->role_id == UserRole::ADMINISTRADOR) {
            return true;
        }

        return $user->id == $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        if ($user->role_id == UserRole::ADMINISTRADOR) {
            return true;
        }

        return $user->id == $model->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->role_id == UserRole::ADMINISTRADOR;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->id == UserRole::ADMINISTRADOR;
    }
}
