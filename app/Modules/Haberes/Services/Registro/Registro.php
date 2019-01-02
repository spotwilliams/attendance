<?php

namespace Cat\Modules\Haberes\Services\Registro;

use Cat\Models\Agente;
use Cat\Models\FacturaFisica;
use Cat\Models\Haber;
use Cat\Models\Periodo;
use Cat\Modules\Haberes\Services\Calculo\Calculador;
use Cat\Modules\Service;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

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
            DB::beginTransaction();
            
            $detalle = $this->supportService->reset($this->agente, $this->periodo)->execute();
            
            /** @var Haber $haber */
            $haber = Haber::firstOrCreate([
                'id_agente'  => $this->agente->id,
                'id_periodo' => $this->periodo->id,
            ]);
            try {
                $turno = $this->agente->operativo->turnoOnDate(new \DateTime($this->periodo->fecha_comienzo))->firstOrFail();
            } catch (ModelNotFoundException $sinTurnoEnEsaFecha) {
                $turno = $this->agente->operativo->turno()->first();
            }
            // Se guardan los haberes
            $haber->update([
                'id_base'         => $this->agente->base()->id,
                'id_turno'        => $turno->id_turno,
                'monto_facturado' => $detalle->monto,
                'monto_contrato'  => $detalle->montoContrato,
            ]);
            
            try {
                /** @var FacturaFisica $factura */
                $factura = FacturaFisica::where('id_agente', '=', $this->agente->id)
                    ->where('id_periodo', '=', $this->periodo->id)
                    ->firstOrFail();
                
                $factura->update(['nro_factura' => $this->nroFactura,]);
            } catch (ModelNotFoundException $exception) {
                FacturaFisica::create([
                    'id_agente'   => $this->agente->id,
                    'id_periodo'  => $this->periodo->id,
                    'nro_factura' => $this->nroFactura,
                ]);
            }
            
            DB::commit();
            
            return true;
        } catch (QueryException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
}