<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 5/8/17
 * Time: 09:18
 */

namespace Cat\Modules\Haberes\Rules;

use Cat\Modules\Presentismo\Exceptions\Validacion\Descriptor;
use Cat\Modules\Presentismo\Exceptions\Validacion\Validation;
use Cat\Models\Ausente as TipoPresentismoAusente;

class Ausente extends Rule
{
    protected function validate()
    {
        // Verificar que sea injustificado
        /** @var TipoPresentismoAusente $ausente */
        $ausente = TipoPresentismoAusente::find($this->tipoAusente->id);
        
        if ($ausente->esInjustificado()) {
            return true;
        } else {
            // Verificar para la categoria de ausentes
            // que el agente tenga dias disponibles
            $diasDisponibles = $this->agente->getCantDiasDisponibles($this->tipoAusente, $this->fecha);
            
            if ($diasDisponibles > 0) {
                return true;
            } else {
                $error = new Validation($this->agente, Descriptor::noTieneDiasDisponibles(), $this->tipoAusente);
                throw $error;
            }
            // Verificar la cantidad de dia
            
        }
        
    }
    
}