<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 5/5/17
 * Time: 11:19
 */

namespace Cat\Modules\Haberes\Services\Calculo;

use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\Periodo;
use Cat\Models\Presentismo;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Service;
use Cat\Modules\Validation\Repositories\PresentismoRepository;

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
        
        /** @var TipoPresentismo $tardanza codigo de los injustifados */
        $tardanza = TipoPresentismo::tardanzas();
        
        /** @var int $diasADescontar Cantidad de dias con faltas no justificadas */
        $diasADescontar = $this->agente
            ->presentismos()
            ->where('id_periodo', '=', $this->periodo->id)
            ->where('injustificado', '=', 1)
            ->where('id_tipo_presentismo', '<>', $tardanza->id)
            ->count();
        $diasADescontar += $this->equivalenteEnTardanzas($tardanza);
        
        if ($this->isWeekend()) {
            $diasADescontar = $diasADescontar * 2;
        }
        $this->monto = floatval($this->montoContrato - ($montoDescontable * $diasADescontar));
        
        return floatval($this->monto);
    }
    
    private function isWeekend()
    {
        return $this->agente
            ->operativo()
            ->first()
            ->turno()
            ->first()
            ->esFinDeSemana();
    }
    
    private function equivalenteEnTardanzas(TipoPresentismo $tardanza)
    {
        $tardanzas = $this->agente
            ->presentismos()
            ->where('id_periodo', '=', $this->periodo->id)
            ->where('injustificado', '=', 1)
            ->where('id_tipo_presentismo', '=', $tardanza->id)
            ->count();
        
        return round($tardanzas / 3);
        
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