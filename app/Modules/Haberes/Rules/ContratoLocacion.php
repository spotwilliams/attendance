<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 5/5/17
 * Time: 12:29
 */

namespace Cat\Modules\Haberes\Rules;

use Cat\Models\Contrato;
use Cat\Modules\Presentismo\Exceptions\Validacion\Descriptor;
use Cat\Modules\Presentismo\Exceptions\Validacion\Validation;

class ContratoLocacion extends Rule
{
    
    protected function validate()
    {
        /** @var Contrato $contrato */
        $contrato = $this->agente->contrato();
        
        if($contrato->esLocacion()) {
            return true;
        } else {
            $error = new Validation($this->agente, Descriptor::noEsContratoLocacion());
            throw $error;
        }
    }
}