<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


class EstadoContrato extends Model
{
    
    const ESTADO_ACTIVO = 'ACTIVO';
    const ESTADO_BAJA   = 'BAJA';
    public $table = 'estado_contratos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    
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
    public function contratos()
    {
        return $this->hasMany(Contrato::class, 'id_estado_contrato');
    }
    
    public function estadoPadreActivo()
    {
        return EstadoContrato::where('estado', EstadoContrato::ESTADO_ACTIVO)->first();
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function padre()
    {
        return $this->belongsTo(EstadoContrato::class, 'id_padre', 'id');
    }
    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function hijos()
    {
        return $this->hasMany(EstadoContrato::class, 'id_padre', 'id');
    }
    
    public function esActivo()
    {
        // Verificar que sea el estado padre activo
        if (strtolower($this->estado) === strtolower(EstadoContrato::ESTADO_ACTIVO)) {
            return true;
        } else {
            // Verificar que sea hijo de activoalguno de sus hijos.
            $padre             = $this->padre();
            $padreEstadoActivo = $this->estadoPadreActivo();
            
            if ($padre->id === $padreEstadoActivo->id) {
                return true;
            } else {
                return false;
            }
        }
    }
}
