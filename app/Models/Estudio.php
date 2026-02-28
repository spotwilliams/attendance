<?php

namespace Cat\Models;

use Cat\Models\Traits\EstudioUpperCase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Estudio extends Model
{
    use SoftDeletes, EstudioUpperCase;
    
    public $table = 'estudios';
    protected $casts = ['deleted_at' => 'datetime'];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable
                     = [
            'carrera',
            'institucion',
            'estado',
            'nivel',
            'id_agente',
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
    public function agente()
    {
        return $this->belongsTo(Agente::class, 'id_agente');
    }
    
    public function printMe()
    {
        return "Carrera: $this->carrera - Instituci&oacute;n: $this->institucion - Nivel: $this->nivel - Estado: $this->estado";
    }
}
