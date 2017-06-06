<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


class Contrato extends Model
{
    const TIPO_LOCACION = 'LOCACION';
    
    public $table = 'contratos';
    
    protected $fillable
        = [
            'fecha_ingreso',
            'id_tipo_contrato',
            'id_estado_contrato',
            'id_agente',
            'id_sial',
            'ficha',
        ];
    
    public static $rules
        = [
            'fecha_ingreso'      => 'required|date',
            'id_tipo_contrato'   => 'not_in:-1',
            'id_estado_contrato' => 'not_in:-1',
            //            'id_agente'          => 'required',
            //            'id_sial'            => 'required',
            //            'ficha'              => 'required',
        
        ];
    
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
    
    
    public function mesIngreso()
    {
        return strtoupper((new \DateTime($this->fecha_ingreso))->format('F'));
    }
    
    public function mesIngresoProporcional()
    {
        $meses = array(
            'JULY',
            'AUGUST',
            'SEPTEMBER',
            'OCTOBER',
            'NOVEMBER',
            'DECEMBER',
        );
        $mes   = $this->mesIngreso();
        if (in_array($mes, $meses)) {
            return $mes;
        } else {
            return array_first($meses);
        }
    }
}
