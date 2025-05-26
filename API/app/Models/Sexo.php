<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Sexo extends Model
{
    use SoftDeletes;
    
    protected $table = 'sexos';
    protected $fillable = ['descricao'];

    const MASCULINO = 1;
    const FEMININO = 2;
    const NAO_INFORMADO = 3;

    public function usuarios() {
        return $this->hasMany(User::class, 'sexo_id', 'id');
    }
}
