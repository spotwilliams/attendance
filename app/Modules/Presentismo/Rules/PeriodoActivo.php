<?php

namespace Cat\Modules\Validation\Rules;

use Cat\Models\Periodo;
use Cat\Modules\Presentismo\Exceptions\Validacion\PeriodoCerrado;

class PeriodoActivo extends Rule
{
    protected function validate()
    {
        
        $periodo = Periodo::findActivo($this->fecha);
        $base    = $this->agente->base();
        $turno   = $this->agente->operativo()->first()->turno()->first();
        
        if ($periodo !== null and $periodo->estaActivo($base, $turno)) {
            return true;
        } else {
            throw new PeriodoCerrado($this->agente, $this->fecha);
        }
        
    }
    
}