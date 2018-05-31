<?php

namespace Cat\Modules\Haberes\Services\Calculo;

use Cat\Models\Agente;
use Cat\Models\Periodo;
use Cat\Modules\Service;
use Cat\Repositories\TipoPresentismosRepository;
use Illuminate\Support\Collection;

class CalculadorBatch extends Service
{
    const FACTOR_DIVISION = 21;
    /** @var Collection */
    protected $agentes;
    
    /** @var Periodo */
    protected $periodo;
    
    /** @var Calculador */
    protected $calculador;
    
    /**
     * CalculadorBatch constructor.
     * @param Collection $agentes
     * @param Periodo $periodo
     */
    public function __construct(Collection $agentes, Periodo $periodo)
    {
        $this->agentes    = $agentes;
        $this->periodo    = $periodo;
        $this->calculador = new Calculador();
    }
    
    
    public function execute()
    {
        /** @var Agente $agente */
        foreach ($this->agentes as $agente) {
            /** @var \stdClass $detalle */
            $detalle = $this->calculador
                ->reset($agente, $this->periodo)
                ->execute();

            $agente->detalle = $detalle;
        }
        
        return $this->agentes;
        
    }
    
    
}