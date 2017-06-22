<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 5/5/17
 * Time: 11:19
 */

namespace Cat\Modules\Haberes\Services\Calculo;

use Cat\Models\Agente;
use Cat\Models\Periodo;
use Cat\Modules\Service;
use Cat\Repositories\TipoPresentismosRepository;

class Calculador extends Service
{
    const FACTOR_DIVISION = 21;
    /** @var Agente */
    protected $agente;
    
    /** @var Periodo */
    protected $periodo;
    
    /** @var  float */
    protected $monto;
    
    /** @var float */
    protected $montoContrato;
    
    /**
     * Calculador constructor.
     * @param Agente $agente
     * @param Periodo $periodo
     */
    public function __construct(Agente $agente, Periodo $periodo)
    {
        $this->load($agente, $periodo);
    }
    
    /**
     * Permite reutilizar el servicio para otros agentes o periodos
     * @param Agente $agente
     * @param Periodo $periodo
     */
    public function reset(Agente $agente, Periodo $periodo)
    {
        $this->load($agente, $periodo);
    }
    
    /**
     * Reinicializa el objeto
     * @param Agente $agente
     * @param Periodo $periodo
     */
    private function load(Agente $agente, Periodo $periodo)
    {
        $this->agente        = $agente;
        $this->periodo       = $periodo;
        $this->montoContrato = floatval($this->agente->contrato()->first()->monto);
        $this->monto         = null;
    }
    
    /**
     * @return bool
     */
    public function execute()
    {
        /** @var float $montoDescontable Monto de referencia para descontar */
        $montoDescontable = floatval($this->montoContrato / Calculador::FACTOR_DIVISION);
        
        /** @var int $diasADescontar Cantidad de dias con faltas no justificadas */
        $diasADescontar = TipoPresentismosRepository::getCantFaltasInjustificadas($this->agente, $this->periodo);
        $this->monto    = floatval($this->montoContrato - ($montoDescontable * $diasADescontar));
        
        return floatval($this->monto);
    }
    
    public function getMontoContrato()
    {
        return $this->montoContrato;
    }
    
    public function getMontoPagar()
    {
        if ($this->monto === null) {
            return $this->execute();
        } else {
            return $this->monto;
        }
    }
    
    
}