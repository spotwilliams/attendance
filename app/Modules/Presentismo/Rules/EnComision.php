<?php

namespace Cat\Modules\Validation\Rules;

use Cat\Models\Contrato;
use Cat\Models\EstadoContrato;
use Cat\Models\TipoPresentismo;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EnComision extends Rule
{
    
    /**
     * @return bool|mixed
     * @throws \Cat\Modules\Presentismo\Exceptions\Validacion\EnComision
     */
    protected function validate()
    {
        try {
            /** @var Contrato $contrato */
            $contrato = $this->agente->contrato()->firstOrFail();
            /** @var EstadoContrato $estadoContrato */
            $estadoContrato = $contrato->estadoContrato()->first();
            
            if ($estadoContrato->id === EstadoContrato::comision()->id) {
                if ($this->tipoAusente->id === TipoPresentismo::eximido()->id) {
                    return true;
                } else {
                    throw new \Cat\Modules\Presentismo\Exceptions\Validacion\EnComision($this->tipoAusente);
                }
            } else {
                return true;
            }
        } catch (ModelNotFoundException $sinContrato) {
            return false;
        }
        
        
    }
    
}