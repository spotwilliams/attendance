<?php

namespace Cat\Modules\Validation\Rules;

use Cat\Models\TipoPresentismo;
use Cat\Modules\Presentismo\Exceptions\Validacion\FechaFutura;

class NoEsFuturo extends Rule
{
    /**
     * @return bool|mixed
     * @throws FechaFutura
     */
    protected function validate()
    {
        
        $today = new \DateTime('now');

        if (($today < $this->fecha) and ($this->tipoAusente->codigo === TipoPresentismo::PRESENTE)) {
            throw new FechaFutura($this->agente, $this->fecha, $this->tipoAusente);
        } else {
            return true;
        }
        
    }
    
}