<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;

class Domicilio extends Model
{
    
    public $table = 'domicilios';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    
    public $fillable
        = [
            'calle',
            'numero',
            'deptartamento',
            'piso',
            'barrio',
            'provincia',
            'libre',
        ];
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts
        = [
            'id'            => 'integer',
            'calle'         => 'string',
            'numero'        => 'string',
            'deptartamento' => 'string',
            'piso'          => 'string',
            'barrio'        => 'string',
            'provincia'     => 'string',
            'libre'         => 'string',
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
        return $this->belongsTo(Agente::class, 'id_agente');
    }
}
