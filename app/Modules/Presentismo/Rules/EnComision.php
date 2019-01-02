<?php

namespace Cat\Modules\Validation\Rules;

use Cat\Models\Contrato;
use Cat\Models\ContratoHistorico;
use Cat\Models\EstadoContrato;
use Cat\Models\TipoPresentismo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class EnComision extends Rule
{
    
    /**
     * @return bool|mixed
     * @throws \Cat\Modules\Presentismo\Exceptions\Validacion\EnComision
     */
    protected function validate()
    {
        try {
            /**
             * @var ContratoHistorico $contrato
             *
             * Este contrato esta vigente durante la fecha consultada (fecha_ingreso, fecha_fin)
             * y tiene asignado comision durante la fecha consultada (fecha_estada_desde/hasta)
             *
             * firstOrFail hace que se genere una excepcion
             */
            $contrato = $this->agente->contratoOnDate($this->fecha)
                ->whereDate('fecha_estado_desde', '<=', $this->fecha)
                ->whereDate('fecha_estado_hasta', '>=', $this->fecha)
                ->where('id_estado_contrato', '=', EstadoContrato::comision()->id)
                ->with('estadoContrato')
                ->with('tipoContrato')
                ->firstOrFail();

            if ($this->tipoAusente->id === TipoPresentismo::eximido()->id) {
                return true;
            } else {
                throw new \Cat\Modules\Presentismo\Exceptions\Validacion\EnComision($this->tipoAusente);
            }
        } catch (ModelNotFoundException $sinComision) {
            // No tiene contrato comision, no hay necesidad de frenar
            return true;
        }
        
    }
    
}