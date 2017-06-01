<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


class Operativo extends Model
{
    
    public $table = 'operativos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    
    public $fillable
        = [
            'id_agente',
            'id_gerencia',
            'id_base',
            'id_area',
            'id_cargo',
            'id_funcion',
            'id_turno',
            'id_horario',
        ];
    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function base()
    {
        return $this->belongsTo(Base::class, 'id_base');
    }
    
    public function agente()
    {
        return $this->belongsTo(Agente::class, 'id_agente');
    }
    
    
    public function gerencia()
    {
        return $this->belongsTo(Gerencia::class, 'id_gerencia');
    }
    
    
    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'id_cargo');
    }
    
    public function funcion()
    {
        return $this->belongsTo(Funcion::class, 'id_funcion');
    }
    
    public function horario()
    {
        return $this->belongsTo(Horario::class, 'id_horario');
    }

    public function turno()
    {
        return $this->belongsTo(Turno::class, 'id_turno');
    }
}
