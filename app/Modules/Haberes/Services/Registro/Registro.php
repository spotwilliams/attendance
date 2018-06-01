<?php

namespace Cat\Modules\Haberes\Services\Registro;

use Cat\Models\Agente;
use Cat\Models\FacturaFisica;
use Cat\Models\Haber;
use Cat\Models\Periodo;
use Cat\Modules\Haberes\Services\Calculo\Calculador;
use Cat\Modules\Service;
use Illuminate\Database\QueryException;

class Registro extends Service
{
    /** @var Agente */
    protected $agente;
    
    /** @var Periodo */
    protected $periodo;
    
    /** @var  Calculador */
    protected $supportService;
    
    /**
     * @var string
     */
    protected $nroFactura;
    
    /**
     * Registro constructor.
     * @param Agente $agente
     * @param Periodo $periodo
     * @param $nroFactura
     */
    public function __construct(Agente $agente, Periodo $periodo, $nroFactura)
    {
        $this->agente         = $agente;
        $this->periodo        = $periodo;
        $this->supportService = new Calculador();
        $this->nroFactura     = $nroFactura;
    }
    
    public function execute()
    {
        
        try {
            
            
            $detalle = $this->supportService->reset($this->agente, $this->periodo)->execute();
            
            /** @var Haber $haber */
            $haber = Haber::firstOrCreate([
                'id_agente'  => $this->agente->id,
                'id_periodo' => $this->periodo->id,
            ]);
            // Se guardan los haberes
            $haber->update([
                'id_base'         => $this->agente->base()->id,
                'id_turno'        => $this->agente->operativo->turnoOnDate(new \DateTime($this->periodo->fecha_comienzo))->first()->id_turno,
                'monto_facturado' => $detalle->monto,
                'monto_contrato'  => $detalle->montoContrato,
            ]);
            
            FacturaFisica::create([
                'id_agente'   => $this->agente->id,
                'id_periodo'  => $this->periodo->id,
                'nro_factura' => $this->nroFactura,
            ]);
            
            
            return true;
        } catch (QueryException $e) {
            
            throw $e;
        }
    }
    
}