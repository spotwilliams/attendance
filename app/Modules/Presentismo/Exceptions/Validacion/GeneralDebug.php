<?php

namespace Cat\Modules\Presentismo\Exceptions\Validacion;


use Cat\Models\Agente;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Presentismo\Exceptions\Descriptor;

class GeneralDebug extends Validation
{
    public function __construct(Agente $agente, \DateTime $fecha, TipoPresentismo $tipo, \Exception $prev)
    {
        $this->fecha = $fecha;
        parent::__construct($agente, Descriptor::debug($prev));
    }
}

