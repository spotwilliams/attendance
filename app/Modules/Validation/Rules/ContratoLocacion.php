<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 5/5/17
 * Time: 12:29
 */

namespace Cat\Modules\Validation\Rules;

use Cat\Modules\Validation\Exceptions\Descriptor;
use Cat\Modules\Validation\Exceptions\Validation;

class ContratoLocacion extends Rule
{
    
    protected function validate()
    {
        $contrato = $this->agente->contrato();
        
        if($contrato->esLocacion()) {
            return true;
        } else {
            $error = new Validation($this->agente, Descriptor::noEsContratoLocacion());
            throw $error;
        }
    }
}