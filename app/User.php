<?php

namespace Cat;

use Cat\Models\Agente;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cat\Security\Panel\Traits\CrudTrait;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use CrudTrait;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'name',
            'email',
            'password',
            'id_agente',
        ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden
        = [
            'password',
            'remember_token',
        ];
    
    public function agente()
    {
        return $this->belongsTo(Agente::class, 'id_agente', 'id');
    }
}
