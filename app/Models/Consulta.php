<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Consulta extends Model
{
    use SoftDeletes;

    protected $table = 'consultas';
    protected $fillable = ['medico_id', 'paciente_id', 'data', 'resultado'];
    protected $hidden = ['created_at', 'deleted_at', 'updated_at'];

    public function paciente() {
        return $this->belongsTo(User::class, 'paciente_id', 'id');
    }

    public function medico() {
        return $this->belongsTo(User::class, 'medico_id', 'id');
    }
}
