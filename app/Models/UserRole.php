<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRole extends Model
{
    const ADMINISTRADOR = 1;
    const MEDICO = 2;
    const PACIENTE = 3;

    use SoftDeletes;

    protected $table = 'user_roles';
    protected $fillable = ['descricao'];
}
