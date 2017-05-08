<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 5/8/17
 * Time: 09:18
 */

namespace Cat\Modules\Validation\Rules;


use Cat\Modules\Validation\Exceptions\Descriptor;
use Cat\Modules\Validation\Exceptions\Validation;

class Ausente extends Rule
{
    protected function validate()
    {
        // Verificar que sea injustificado
        $esInjustificado = $this->tipoAusente->esInjustificado();
        
        if ($esInjustificado) {
            
        } else {
            // Verificar para la categoria de ausentes
            // que el agente tenga dias disponibles
            $diasDisponibles = $this->agente->getCantDiasDisponibles($this->tipoAusente);
            
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