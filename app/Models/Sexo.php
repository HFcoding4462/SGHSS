<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sexo extends Model
{
    protected $table = 'sexos';
    protected $fillable = ['descricao'];

    const MASCULINO = 1;
    const FEMININO = 2;
    const NAO_INFORMADO = 3;
}
