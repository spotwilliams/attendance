<?php

namespace Cat\Modules\Validation\Rules;


use Cat\Models\EstadoContrato;
use Cat\Models\TipoPresentismo;
class EnComision extends Rule
{
    
    /**
     * @return bool|mixed
     * @throws \Cat\Modules\Presentismo\Exceptions\Validacion\EnComision
     */
    protected function validate()
    {
        
        $estadoContrato = $this->agente->contrato()->first()->estadoContrato()->first();

        if ($estadoContrato->id === EstadoContrato::comision()->id) {
            if($this->tipoAusente->id === TipoPresentismo::eximido()->id) {
                return true;
            } else {
                throw new \Cat\Modules\Presentismo\Exceptions\Validacion\EnComision($this->tipoAusente);
            }
        } else {
            return true;
        }
        
    }
    
}