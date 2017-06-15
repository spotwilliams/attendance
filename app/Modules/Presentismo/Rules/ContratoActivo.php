<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 5/5/17
 * Time: 12:29
 */

namespace Cat\Modules\Validation\Rules;


use Cat\Models\Agente;
use Cat\Models\Contrato;
use Cat\Modules\Presentismo\Exceptions\Validacion\Descriptor;
use Cat\Modules\Presentismo\Exceptions\Validacion\Validation;

class ContratoActivo extends Rule
{
    
    protected function validate()
    {
        /** @var Contrato $contrato */
        $contrato = $this->agente->contrato()->first();
        $activo   = $contrato->estadoContrato()->first()->esActivo();

        if ($activo) {
            return true;
        } else {
            $error = new Validation($this->agente, Descriptor::contratoInactivo());
            throw $error;
        }
        
    }
    
}