<?php

namespace Cat\Modules\Agentes\Services\Registro\Traits;


use Cat\Models\Agente;
use Cat\Models\EstadoContrato;
use Cat\Models\TipoContrato;

trait LaboralesSetup
{
    /** @var Agente */
    protected $agente;
    
    /** @var  string */
    protected $ficha;
    
    /** @var  \DateTime */
    protected $fecha;
    
    /** @var  string Casting before save */
    protected $monto;
    
    /** @var  EstadoContrato */
    protected $estado;
    
    /** @var  TipoContrato */
    protected $tipo;
    
    /** @var  string */
    protected $id_sial;
    
    /** @var  \DateTime */
    protected $fecha_fin;
    
    /** @var  string */
    protected $comentario;
    
    /** @var  \DateTime */
    protected $tipo_inscripcion;
    
    /** @var  \DateTime */
    protected $fecha_ingreso_gobierno;
    
    /** @var  \DateTime */
    protected $fecha_estado_desde;
    
    /** @var  \DateTime */
    protected $fecha_estado_hasta;
    
    /**
     * Shared between store and update
     * @param Agente $agente
     * @param $input
     */
    protected function setup(Agente $agente, $input)
    {
        $this->agente                 = $agente;
        $this->monto                  = (empty($input['monto']) or !isset($input['monto'])) ? config('cat.monto_contrato') : $input['monto'];
        $this->fecha                  = new \DateTime($input['fecha_ingreso']);
        $this->estado                 = EstadoContrato::findOrFail($input['id_estado_contrato']);
        $this->tipo                   = TipoContrato::findOrFail($input['id_tipo_contrato']);
        $this->fecha_ingreso_gobierno = new \DateTime($input['fecha_ingreso_gobierno']);
        
        // Por tipo de contrato
        if ($this->tipo->codigo === TipoContrato::TIPO_SITUACION_REVISTA) {
            $this->id_sial = $input['id_sial'];
            $this->ficha   = $input['ficha'];
        } else {
            $this->tipo_inscripcion = $input['tipo_inscripcion'];
            $this->fecha_fin        = new \DateTime($input['fecha_fin']);
        }
        
        // Para Bajas o comisiones
        if (!$this->estado->esActivo() or ($this->estado->id === EstadoContrato::comision()->id)) {
            $this->comentario         = $input['comentario'];
            $this->fecha_estado_desde = new \DateTime($input['fecha_estado_desde']);
            $this->fecha_estado_hasta = new \DateTime($input['fecha_estado_hasta']);
        }
        
    }
    
    
    protected function getData()
    {
        return [
            'id_tipo_contrato'       => $this->tipo->id,
            'id_estado_contrato'     => $this->estado->id,
            'id_agente'              => $this->agente->id,
            'id_sial'                => $this->id_sial,
            'ficha'                  => $this->ficha,
            'monto'                  => floatval($this->monto),
            'comentario'             => $this->comentario,
            'tipo_inscripcion'       => $this->tipo_inscripcion,
            'fecha_ingreso'          => ($this->fecha->format('Y-m-d') === null) ? null : $this->fecha->format('Y-m-d'),
            'fecha_fin'              => ($this->fecha_fin === null) ? null : $this->fecha_fin->format('Y-m-d'),
            'fecha_ingreso_gobierno' => ($this->fecha_ingreso_gobierno === null) ? null : $this->fecha_ingreso_gobierno->format('Y-m-d'),
            'fecha_estado_desde'     => ($this->fecha_estado_desde === null) ? null : $this->fecha_estado_desde->format('Y-m-d'),
            'fecha_estado_hasta'     => ($this->fecha_estado_hasta === null) ? null : $this->fecha_estado_hasta->format('Y-m-d'),
        ];
    }
}