<?php

namespace Cat\Modules\Validation\Rules;

use Cat\Exceptions\AgenteSinBase;
use Cat\Exceptions\AgenteSinTurno;
use Cat\Models\Periodo;
use Cat\Modules\Presentismo\Exceptions\Validacion\PeriodoCerrado;
use Cat\Repositories\PeriodoRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PeriodoActivo extends Rule
{
    /**
     * @return bool|mixed
     * @throws AgenteSinBase
     * @throws AgenteSinTurno
     * @throws PeriodoCerrado
     */
    protected function validate()
    {
        
        $periodo = PeriodoRepository::getOrCreatePeriodoActivo($this->fecha);
        
        if ($periodo === null) {
            throw new PeriodoCerrado($this->agente, $this->fecha);
    
        } else {
            return true;
        }
        
        /**
         * @obsolete Waiting reconsiderations
         */
        try {
            
            $base = $this->agente->base();
        } catch (ModelNotFoundException $sinBase) {
            throw new AgenteSinBase($this->agente);
        }
        try {
            $turno = $this->agente->operativo()->firstOrFail()->turno()->firstOrFail();
        } catch (ModelNotFoundException $sinTurno) {
            throw new AgenteSinTurno($this->agente);
        }
        
        $haber = $periodo->haberes()
            ->where('id_agente', '=', $this->agente->id)
            ->first();
        
        // El agente no ha entregado la factura, por lo tanto se pueden hacer cambios
        if ($haber->id_estado !== EstadoHaber::facturaEntregada()->id) {
            return true;
        } else {
            throw new PeriodoCerrado($this->agente, $this->fecha);
        }
        
    }
    
}