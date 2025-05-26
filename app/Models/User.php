<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\UserRole;
use App\Models\CRM;
use App\Models\Consulta;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'cpf',
        'idade',
        'sexo_id',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'sexo_id',
        'role_id',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
        'email_verified_at',
    ];

    protected $appends = ['role', 'sexo'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function boot(): void {
        parent::boot();

        static::creating(function($user) {
            if ($user->role_id == null) {
                $user->role_id = UserRole::PACIENTE;
            }
        });

        static::updating(function ($user) {
            if ($user->role_id == null) {
                $user->role_id = UserRole::PACIENTE;
            }
        });
    }

    public function role() {
        return $this->belongsTo(UserRole::class, 'role_id', 'id');
    }

    public function sexo() {
        return $this->belongsTo(Sexo::class, 'sexo_id', 'id');
    }

    public function crm() {
        return $this->hasOne(CRM::class, 'medico_id', 'id');
    }

    public function consultas() {
        $role = $this->role_id;

        return $this->hasMany(Consulta::class, $role == UserRole::MEDICO ? 'medico_id' : 'paciente_id', 'id');
    }

    public function getSexoAttribute() {
        return $this->sexo()->get()->first()->descricao;
    }

    public function getRoleAttribute() {
        return $this->role()->get()->first()->descricao;
    }

    public function getCrmAttribute() {
        $crm = $this->crm()->get()->first();

        if (!$crm) {
            return null;
        }

        return $crm->crm;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
