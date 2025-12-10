<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Contrato extends Model
{
    use SoftDeletes;
    
    const TIPO_LOCACION = 'LOCACION';
    
    public $table = 'contratos';
    
    protected $fillable
                     = [
            'id_tipo_contrato',
            'id_estado_contrato',
            'id_agente',
            'id_sial',
            'ficha',
            'monto',
            'comentario',
            'comentario_estado',
            'tipo_inscripcion',
            'fecha_ingreso',
            'fecha_fin',
            'fecha_ingreso_gobierno',
            'fecha_estado_desde',
            'fecha_estado_hasta',
        ];
    protected $dates = ['deleted_at'];
    
    public static $rules
        = [
            'fecha_ingreso'          => 'required|date|fecha_contrato_futuro|fecha_contrato',
            'fecha_ingreso_gobierno' => 'date|fecha_contrato_futuro',
            'id_tipo_contrato'   => 'not_in:-1',
            'id_estado_contrato' => 'not_in:-1',
        ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function estadoContrato()
    {
        return $this->belongsTo(EstadoContrato::class, 'id_estado_contrato', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function tipoContrato()
    {
        return $this->belongsTo(TipoContrato::class, 'id_tipo_contrato');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function agentes()
    {
        return $this->belongsTo(Agente::class, 'id_agente');
    }
    
    public function agente()
    {
        return $this->belongsTo(Agente::class, 'id_agente');
    }
    
    /**
     * True si es del tipo Locacion de servicios
     * @return bool
     */
    public function esLocacion()
    {
        if (strtolower($this->tipoContrato()->first()->codigo) === strtolower(Contrato::TIPO_LOCACION)) {
            return true;
        } else {
            return false;
        }
    }
    
    
    public function mesIngreso()
    {
        return strtoupper((new \DateTime($this->fecha_ingreso))->format('F'));
    }
    
    public function mesIngresoProporcional(\DateTime $fechaReferencia)
    {
        $meses = array(
            'JULY',
            'AUGUST',
            'SEPTEMBER',
            'OCTOBER',
            'NOVEMBER',
            'DECEMBER',
        );
        
        $tipoContrato = $this->tipoContrato()->first();
        if ($tipoContrato and ($tipoContrato->codigo === TipoContrato::TIPO_SITUACION_REVISTA)) {
            // Si es planta, ya no se actualiza el contrato por lo tanto se lo toma como enero
            $mes = 'JANUARY';
        } else {
            
            $fIngreso     = new \DateTime($this->fecha_ingreso);
            $yearIngreso  = (int)$fIngreso->format('Y');
            $yearPresente = (int)$fechaReferencia->format('Y');
            if ($yearIngreso === $yearPresente) {
                $mes = $this->mesIngreso();
            } else {
                // Si el ingreso fue en otro year, entonces se toma como referencia julio (all year)
                $mes = 'JANUARY';
            }
        }
        
        
        if (in_array($mes, $meses)) {
            return $mes;
        } else {
            return \Illuminate\Support\Arr::first($meses);
        }
    }
}
