<?php

namespace Cat\Modules\Presentismo\Exceptions\Validacion;

use Cat\Models\Agente;
use Cat\Models\Periodo;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Presentismo\Exceptions\Descriptor;


class PeriodoFacturado extends Validation
{
    /** @var Periodo  */
    protected $periodo;
    
    /** @var \DateTime  */
    protected $fecha;
    
    public function __construct(Agente $agente, \DateTime $fecha, TipoPresentismo $tipo, Periodo $periodo)
    {
        $this->fecha   = $fecha;
        $this->periodo = $periodo;
        
        parent::__construct($agente, Descriptor::periodoFacturado());
    }
}