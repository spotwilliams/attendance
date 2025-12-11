<?php

namespace Cat\Modules\Haberes\Services\Calculo;

use Cat\Models\Agente;
use Cat\Models\Periodo;
use Cat\Models\Presentismo;
use Cat\Models\TipoPresentismo;
use Cat\Models\Turno;
use Cat\Modules\Service;
use Cat\Repositories\TipoPresentismosRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class Calculador extends Service
{
    const FACTOR_DIVISION = 30;
    /** @var Agente */
    protected $agente;
    
    /** @var Periodo */
    protected $periodo;
    
    /** @var  \stdClass */
    protected $detalle;

    /**
     * @param Agente $agente
     * @param Periodo $periodo
     * @return $this
     * @throws \Exception
     */
    public function reset(Agente $agente, Periodo $periodo)
    {
        $this->load($agente, $periodo);
        
        return $this;
    }

    /**
     * @param Agente $agente
     * @param Periodo $periodo
     * @return $this
     * @throws \Exception
     */
    private function load(Agente $agente, Periodo $periodo)
    {
        $this->agente  = $agente;
        $this->periodo = $periodo;
        
        // Definimos cuanto detalle vamos a devolver
        $this->detalle           = new \stdClass();
        $this->detalle->tard     = 0;
        $this->detalle->fins     = 0;
        $this->detalle->sema     = 0;
        $this->detalle->tardEqui = 0;
        $this->detalle->monto    = 0;
        try {
            $date     = (new \DateTime($periodo->fecha_comienzo))->modify('+2 month');
            $contrato = $this->agente->contratoOnDate($date)->firstOrFail();
            $monto    = (int)$contrato->monto;
        } catch (ModelNotFoundException $sinContrato) {
            $monto = 0;
        }
        $this->detalle->montoContrato    = $monto;
        $this->detalle->montoDescontable = round($this->detalle->montoContrato / Calculador::FACTOR_DIVISION);
        $this->detalle->diasADescontar   = 0;
        
        return $this;
    }
    
    /**
     * @return \stdClass()
     */
    public function execute()
    {
        
        /** @var Collection $presentismos */
        $presentismos = $this->agente->presentismos->groupBy(fn($presentismo) => $presentismo->injustificado === true ? 'injustificado' : 'justificado');
        /** @var Presentismo $presentismo */
        if ($presentismos->has('injustificado')) {
            /** @var Presentismo $preInjustificado */
            foreach ($presentismos->get('injustificado') as $preInjustificado) {
                if ($preInjustificado->tipoPresentismo->codigo === TipoPresentismo::TARDANZA) {
                    $this->detalle->tard++;
                } elseif ($preInjustificado->turno->esFinDeSemana()) {
                    // Los fin de semana valen doble
                    $this->detalle->fins += config('cat.presentismos.equivalencia.injustificado.fin_semana');
                } else {
                    $this->detalle->sema++;
                }
            }
            
        }
        // actualizamos las tardanzas al valor que corresponde
        $this->detalle->tardEqui = floor($this->detalle->tard / config('cat.presentismos.equivalencia.injustificado.tardanza'));
        
        /** @var int $diasADescontar Cantidad de dias con faltas no justificadas */
        $this->detalle->diasADescontar = $this->detalle->sema + $this->detalle->tardEqui + $this->detalle->fins;
        // Se trunca a pedido del cliente
        $this->detalle->monto = (int)floatval($this->detalle->montoContrato - ($this->detalle->montoDescontable * $this->detalle->diasADescontar));
        
        return $this->detalle;
    }
    
}