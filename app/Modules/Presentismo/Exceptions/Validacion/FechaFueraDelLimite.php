<?php

namespace Cat\Modules\Presentismo\Exceptions\Validacion;

use Cat\Models\Agente;
use Cat\Models\Periodo;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Presentismo\Exceptions\Descriptor;

class FechaFueraDelLimite extends Validation
{
    public function __construct(Agente $agente, \DateTime $fecha, TipoPresentismo $tipo, Periodo $periodo)
    {
        $this->fecha   = $fecha;
        $this->periodo = $periodo;
        
        parent::__construct($agente, Descriptor::fechaFueraDelLimite());
    }
    
}