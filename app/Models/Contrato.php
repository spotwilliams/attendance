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
            'fecha_ingreso',
            'fecha_ingreso_gobierno',
            'id_tipo_contrato',
            'id_estado_contrato',
            'id_agente',
            'id_sial',
            'ficha',
            'tipo_inscripcion',
            'fin_semana',
            'monto',
            'fecha_baja',
            'comentario_baja',
            'comentario_comision',
            'comision_desde',
            'comision_hasta',
        ];
    protected $dates = ['deleted_at'];
    
    public static $rules
        = [
            'fecha_ingreso'          => 'required|date|fecha_contrato_futuro|fecha_contrato',
            'fecha_ingreso_gobierno' => 'date|fecha_contrato_futuro',
            'fecha_baja'             => 'date|required',
            'comentario_baja'        => 'required',
            'id_tipo_contrato'       => 'not_in:-1',
            'id_estado_contrato'     => 'not_in:-1',
            'tipo_inscripcion'       => 'not_in:-1',
            //            'id_agente'          => 'required',
            //            'id_sial'            => 'required',
            //            'ficha'              => 'required',
        
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
            return array_first($meses);
        }
    }
}
