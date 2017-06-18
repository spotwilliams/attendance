<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 5/8/17
 * Time: 09:18
 */

namespace Cat\Modules\Validation\Rules;


use Cat\Models\Periodo;
use Cat\Modules\Presentismo\Exceptions\Validacion\Descriptor;
use Cat\Modules\Presentismo\Exceptions\Validacion\PeriodoCerrado;
use Cat\Modules\Presentismo\Exceptions\Validacion\Validation;

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