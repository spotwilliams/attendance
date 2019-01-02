<?php

namespace Cat\Modules\Presentismo\Exceptions\Validacion;

use Cat\Models\Agente;
use Cat\Models\Periodo;
use Cat\Modules\Presentismo\Exceptions\Descriptor;

class PeriodoAbierto extends \Exception
{
    
    /** @var Periodo */
    protected $periodo;
    
    public function __construct(Periodo $periodo)
    {
        $this->periodo = $periodo;
        parent::__construct(Descriptor::periodoAbiertoParaCalcular()->getDescription());
    }
}