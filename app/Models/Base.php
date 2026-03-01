<?php

namespace Cat\Models;

use Cat\Modules\Security\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Base extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public $table = 'bases';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    
    public $fillable
        = [
            'nombre',
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
    /**
     * The attributes that should be casted to native types.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
            'id'     => 'integer',
            'nombre' => 'string',
        ];
    }
    
}
