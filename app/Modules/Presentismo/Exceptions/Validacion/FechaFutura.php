<?php

namespace Cat\Modules\Presentismo\Exceptions\Validacion;

use Cat\Models\Agente;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Presentismo\Exceptions\Descriptor;

class FechaFutura extends Validation
{

    /** @var  \DateTime */
    protected $fecha;
    
    
    public function __construct(Agente $agente, \DateTime $fecha, TipoPresentismo $tipo)
    {
        $this->fecha = $fecha;
        parent::__construct($agente, Descriptor::fechaFutura($tipo));
    }
}