<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Domicilio extends Model
{
    use SoftDeletes;
    public $table = 'domicilios';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    protected $dates = ['deleted_at'];
    
    public $fillable
        = [
            'calle',
            'numero',
            'departamento',
            'piso',
            'barrio',
            'provincia',
            'constituido',
            'libre',
            'codigo_postal',
            'id_agente',
        ];
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts
        = [
            'id'            => 'integer',
            'codigo_postal' => 'integer',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function agentes()
    {
        return $this->belongsTo(Agente::class, 'id_agente');
    }
    
    public function printMe()
    {
        return "Calle: $this->calle - Nro: $this->numero - Departamento: $this->departamento - Piso: $this->piso - Barrio: $this->barrio - Provincia: $this->provincia - Constituido: " . (($this->constituido == true) ? 'SI' : 'NO') . " - Otro dato: $this->libre";
    }
}
