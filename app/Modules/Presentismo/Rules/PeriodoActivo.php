<?php

namespace Cat\Modules\Validation\Rules;

use Cat\Exceptions\AgenteSinBase;
use Cat\Exceptions\AgenteSinTurno;
use Cat\Models\Periodo;
use Cat\Modules\Presentismo\Exceptions\Validacion\PeriodoCerrado;
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
        
        $periodo = Periodo::findActivo($this->fecha);
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
        
        if ($periodo !== null and $periodo->estaActivo($base, $turno)) {
            return true;
        } else {
            throw new PeriodoCerrado($this->agente, $this->fecha);
        }
        
    }
    
}