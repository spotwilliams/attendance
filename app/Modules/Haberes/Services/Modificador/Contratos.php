<?php

namespace Cat\Modules\Haberes\Services\Modificador;

use Cat\Models\Agente;
use Cat\Models\Contrato;
use Cat\Models\ContratoHistorico;
use Cat\Models\EstadoContrato;
use Cat\Models\Operativo;
use Cat\Models\TipoContrato;
use Cat\Modules\Service;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Contratos extends Service
{
    /** @var array */
    private $gerencias;
    
    /** @var \DateTime */
    private $fechaContrato;
    
    /** @var float */
    private $monto;
    
    /**
     * Contratos constructor.
     * @param array $gerencias
     * @param \DateTime $fechaContrato
     * @param float $monto
     */
    public function __construct(array $gerencias, \DateTime $fechaContrato, $monto)
    {
        $this->gerencias     = $gerencias;
        $this->fechaContrato = $fechaContrato;
        $this->monto         = $monto;
    }
    
    /**
     * @throws \Exception
     */
    public function execute()
    {
        try {
            DB::beginTransaction();
            
            /** @var array $agentesEnGerencias */
            $agentesEnGerencias = Operativo::select(['id_agente'])
                ->whereIn('id_gerencia', $this->gerencias)
                ->get()
                ->pluck('id_agente');
            
            /** @var array $contratosLocacionActivos Contratos de locacion activos */
            $contratosLocacionActivos = Contrato::whereIn('id_agente', $agentesEnGerencias)
                ->whereIn('id_tipo_contrato', TipoContrato::getEquivalentesLocacion()->pluck('id'))
                ->whereNotIn('id_estado_contrato', EstadoContrato::getEstadosEquivalentesBajas()->pluck('id'))
                ->with('agente')
                ->get();
//
//            /** @var Collection $contratos */
//            $contratos = Contrato::whereIn('id_agente', $agentesLocacion)
//                ->get();
            
            // Actualizo cada contrato
            $fechaFin = ((int)$this->fechaContrato->format('Y')) . '-12-31';
            
            foreach ($contratosLocacionActivos as $contrato) {
                
                $contrato->update([
                    'monto'         => $this->monto,
                    'fecha_ingreso' => $this->fechaContrato->format('Y-m-d'),
                    'fecha_fin'     => $fechaFin,
                ]);
                
                $this->logCambioContrato($contrato->agente, $contrato);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    public function logCambioContrato(Agente $agente, Contrato $contratoActual)
    {
        $this->updateFechaFinContratoHistoricoAnterior($agente, $contratoActual);
        $this->createContratoHistorico($contratoActual);
    }
    
    private function updateFechaFinContratoHistoricoAnterior(Agente $agente, Contrato $contratoActual)
    {
        $historicoActual = $agente->contratosHistoricos()
            ->orderBy('id', 'DESC')
            ->firstOrFail();
        
        
        $fechaFin = (new \DateTime($contratoActual->fecha_ingreso));
        $fechaFin->modify('-1day');
        
        $historicoActual->update([
            'fecha_fin' => $fechaFin->format('Y-m-d'),
        ]);
        
        
    }
    
    
    private function createContratoHistorico(Contrato $contratoActual)
    {
        ContratoHistorico::create($contratoActual->toArray());
    }
    
    
}