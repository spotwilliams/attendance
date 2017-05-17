<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


class Contrato extends Model
{
    const TIPO_LOCACION = 'LOCACION';
    
    public $table = 'contratos';
    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function estadoContrato()
    {
        return $this->belongsTo(EstadoContrato::class, 'id_estado_contrato')->first();
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function tipoContrato()
    {
        return $this->belongsTo(TipoContrato::class, 'id_tipo_contrato')->first();
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function agentes()
    {
        return $this->belongsTo(Agente::class, 'id_agente');
    }
    
    
    /**
     * True si es del tipo Locacion de servicios
     * @return bool
     */
    public function esLocacion()
    {
        if (strtolower($this->tipoContrato()->codigo) === strtolower(Contrato::TIPO_LOCACION)) {
            return true;
        } else {
            return false;
        }
    }
}
