<?php

namespace Cat\Modules\Haberes\Services\Registro;

use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\Haber;
use Cat\Models\Periodo;
use Cat\Models\Turno;
use Cat\Modules\Haberes\Services\Calculo\Calculador;
use Cat\Modules\Service;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Registro extends Service
{
    /** @var Agente */
    protected $agente;
    
    /** @var Periodo */
    protected $periodo;
    
    /** @var Base */
    protected $base;
    
    /** @var Turno */
    protected $turno;
    
    /** @var  Calculador */
    protected $supportService;
    
    public function __construct(Agente $agente, Periodo $periodo, Turno $turno, Base $base)
    {
        $this->agente         = $agente;
        $this->periodo        = $periodo;
        $this->base           = $base;
        $this->turno          = $turno;
        $this->supportService = new Calculador($this->agente, $this->periodo);
    }
    
    public function reset(Agente $agente, Periodo $periodo, Turno $turno, Base $base)
    {
        $this->agente  = $agente;
        $this->periodo = $periodo;
        $this->base    = $base;
        $this->turno   = $turno;
        $this->supportService->reset($this->agente, $this->periodo);
        
        return $this;
    }
    
    public function execute()
    {
        /*
         * Se debe verificar si el presentismo ya fue cargado para ese dia y ese agente
         * 1) Existe: update de presentismo y dia_disponible
         * 2) No existe: insert presentismo y update dia_disponible
         */
        try {
            
            DB::beginTransaction();
            
            $montoContrato = $this->supportService->getMontoContrato();
            $montoPagar    = $this->supportService->getMontoPagar();
            // Se guardan los haberes
            Haber::create([
                'id_agente'       => $this->agente->id,
                'id_periodo'      => $this->periodo->id,
                'id_base'         => $this->base->id,
                'id_turno'        => $this->turno->id,
                'monto_facturado' => $montoPagar,
                'monto_contrato'  => $montoContrato,
            ]);
            
            DB::commit();
            
            return true;
        } catch (QueryException $e) {
            DB::rollBack();
            
            throw $e;
        }
    }
    
}