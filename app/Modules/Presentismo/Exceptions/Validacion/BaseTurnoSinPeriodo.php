<?php

namespace Cat\Modules\Presentismo\Exceptions\Validacion;

use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\Periodo;
use Cat\Models\Turno;
use Cat\Modules\Presentismo\Exceptions\Descriptor;

class BaseTurnoSinPeriodo extends Validation
{
    
    /** @var Periodo */
    protected $periodo;
    
    /** @var Base */
    protected $base;
    
    /** @var Turno */
    protected $turno;
    
    /**
     * BaseTurnoSinPeriodo constructor.
     * @param Agente $agente
     * @param Periodo $periodo
     * @param Base $base
     * @param Turno $turno
     */
    public function __construct(Periodo $periodo, Base $base, Turno $turno)
    {
        $this->periodo = $periodo;
        $this->base    = $base;
        $this->turno   = $turno;
        
        parent::__construct(new Agente(), Descriptor::baseTurnoSinPeriodo($periodo, $base, $turno));
        
    }
}