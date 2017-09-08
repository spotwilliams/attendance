<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 5/8/17
 * Time: 09:18
 */

namespace Cat\Modules\Validation\Rules;

use Cat\Modules\Presentismo\Exceptions\Validacion\SinDiasDisponibles;
use Cat\Modules\Presentismo\Exceptions\Validacion\SinTopeONoEstablecido;
use Cat\Modules\Presentismo\Exceptions\Validacion\Validation;
use Cat\Models\TipoPresentismo;

class Ausente extends Rule
{
    protected function validate()
    {
        // Verificar que sea injustificado
        /** @var TipoPresentismo $ausente */
        $ausente = TipoPresentismo::find($this->tipoAusente->id);
        
        // Verificar para la categoria de ausentes
        // que el agente tenga dias disponibles
        // Verificar la cantidad de dia
        $diasDisponibles = $this->agente->getCantDiasDisponibles($this->tipoAusente, $this->fecha);
        
        if ($diasDisponibles > 0) {
            return true;
        } else {
            throw new SinDiasDisponibles($this->agente, $this->tipoAusente);
        }
    }
    
}