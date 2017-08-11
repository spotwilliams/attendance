<?php

namespace Cat\Modules\Validation\Rules;

use Cat\Modules\Presentismo\Exceptions\Validacion\FechaFutura;

class NoEsFuturo extends Rule
{
    protected function validate()
    {
        
        $today = new \DateTime('now');
        
        if ($today >= $this->fecha) {
            return true;
        } else {
            throw new FechaFutura($this->agente, $this->fecha);
        }
        
    }
    
}