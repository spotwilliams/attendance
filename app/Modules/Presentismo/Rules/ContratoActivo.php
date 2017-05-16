<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 5/5/17
 * Time: 12:29
 */

namespace Cat\Modules\Validation\Rules;


use Cat\Models\Agente;
use Cat\Modules\Validation\Exceptions\Descriptor;
use Cat\Modules\Validation\Exceptions\Validation;

class ContratoActivo extends Rule
{
    
    protected function validate()
    {
        $activo = $this->agente->contrato()->estadoContrato()->esActivo();
        
        if($activo) {
            return true;
        } else {
            $error = new Validation($this->agente, Descriptor::contratoInactivo());
            throw $error;
        }
        
    }
    
}