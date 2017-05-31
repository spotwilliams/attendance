<?php

namespace Cat\Models;

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
        
        ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function agentes()
    {
//        return $this->hasMany(Agente::class, 'id_base');
//        return $this->join(Operativo::class);
        return $this->operativos()
            ->join('agentes', 'agentes.id', '=', 'operativos.id_agente')
            ;
        
    }
    
    
    public function operativos()
    {
        return $this->hasMany(Operativo::class, 'id_base');
        
    }
    
}
