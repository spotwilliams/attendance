<?php

namespace Cat\Models;

use Cat\Modules\Security\Models\Role;
use Illuminate\Database\Eloquent\Model;


class Base extends Model
{
    
    public $table = 'bases';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    
    public $fillable
        = [
            'nombre',
        ];
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts
        = [
            'id'     => 'integer',
            'nombre' => 'string',
        ];
    
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules
        = [
            'nombre' => 'required',
        ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function agentes()
    {
        return $this->operativos()
            ->join('agentes', 'agentes.id', '=', 'operativos.id_agente');
    }
    
    
    public function operativos()
    {
        return $this->hasMany(Operativo::class, 'id_base');
        
    }
    
    public function periodos()
    {
        return $this->belongsToMany(Periodo::class, 'estado_periodos', 'id_base', 'id_periodo')->withPivot(['abierto']);
    }
    
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'base_roles', 'base_id', 'role_id');
    }
    
}
