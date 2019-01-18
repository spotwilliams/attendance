<?php

namespace Cat\Modules\Validation\Rules;

use Cat\Exceptions\AgenteSinBase;
use Cat\Exceptions\AgenteSinTurno;
use Cat\Models\Contrato;
use Cat\Models\FacturaFisica;
use Cat\Models\Periodo;
use Cat\Models\TipoContrato;
use Cat\Modules\Presentismo\Exceptions\Validacion\FechaFueraDelLimite;
use Cat\Modules\Presentismo\Exceptions\Validacion\GeneralDebug;
use Cat\Modules\Presentismo\Exceptions\Validacion\PeriodoCerrado;
use Cat\Modules\Presentismo\Exceptions\Validacion\PeriodoFacturado;
use Cat\Repositories\PeriodoRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PeriodoActivo extends Rule
{
    /** @var Periodo */
    protected $periodo;
    protected $map
        = [
            TipoContrato::TIPO_LOCACION          => 'checkLocacion',
            TipoContrato::TIPO_SITUACION_REVISTA => 'checkSituacionRevista',
        ];
    
    protected function validate()
    {
        /** @var Periodo $periodo */
        $this->periodo = PeriodoRepository::getOrCreatePeriodoActivo($this->fecha);
        
        /** @var Contrato $contrato */
        $contrato = $this->agente->contratoOnDate($this->fecha)
            ->with('tipoContrato')
            ->first();
        
        return $this->{$this->map[$contrato->tipoContrato->codigo]}();
        
    }
    
    /**
     * @return bool
     * @throws PeriodoFacturado
     */
    protected function checkLocacion()
    {
        try {
            $facturaFisica = FacturaFisica::where('id_agente', '=', $this->agente->id)
                ->where('id_periodo', '=', $this->periodo->id)
                ->firstOrFail();
            
            // Si la factura ya existe, tengo que bloquear la carga
            throw new PeriodoFacturado($this->agente, $this->fecha, $this->tipoAusente, $this->periodo);
            
        } catch (ModelNotFoundException $sinHaberRegistrado) {
            
            // El agente no tiene una factura registrada, por lo tanto se puede seguir trabajando
            return true;
        }
    }
    
    /**
     * @return bool
     * @throws FechaFueraDelLimite
     */
    protected function checkSituacionRevista()
    {
        // Si 'now' es menor a fecha (fecha futura), entonces
        // invert es 1 (uno)
        // Si 'now' es mayor a fecha (fecha pasada), entonces
        // invert es 0 (cero)
        $diff = $this->fecha->diff(new \DateTime('now'));
        
        if (($diff->invert === 1) || ((int) $diff->days <= (int) config('cat.limite_dias_planta'))) {
            // Si estan cargando fechas futuras, o si es una fecha dentro del limite de dias
            return true;
        } else {
            throw new FechaFueraDelLimite($this->agente, $this->fecha, $this->tipoAusente, $this->periodo);
        }
        
    }
    
}