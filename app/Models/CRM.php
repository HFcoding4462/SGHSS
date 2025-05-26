<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class CRM extends Model
{
    use SoftDeletes;
    
    protected $table = 'crms';
    protected $fillable = ['medico_id', 'crm'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function medico() {
        return $this->belongsTo(User::class, 'medico_id', 'id');
    }
}
