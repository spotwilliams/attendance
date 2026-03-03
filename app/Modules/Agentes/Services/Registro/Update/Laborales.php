<?php

namespace Cat\Modules\Agentes\Services\Registro\Update;


use Cat\Models\Agente;
use Cat\Models\Contrato;
use Cat\Models\ContratoHistorico;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Cat\Modules\Agentes\Services\Registro\Traits\LaboralesSetup;
use Cat\Modules\Service;
use Illuminate\Support\Facades\DB;

class Laborales extends Service
{
    
    use LaboralesSetup;
    
    public function __construct(Agente $agente, $input)
    {
        // Shared with Store
        $this->setup($agente, $input);
    }
    
    
    public function execute()
    {
        // Es el ultimo contrato que se registro
        
        try {
            DB::beginTransaction();
            
            
            $contratoActual = $this->agente
                ->contrato()
                ->with('estadoContrato')
                ->with('tipoContrato')
                ->orderBy('id', 'DESC')
                ->firstOrFail();
            
            // Actualizo los datos segun los solicitado
            $data = $this->getData();
            $contratoActual->update(array_filter($data));
            
            $this->logCambioContrato($contratoActual);
            
            AgenteRepository::storeCountActivos();
            DB::commit();
            
            return $this->agente;
            
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        
    }
    
    public function logCambioContrato(Contrato $contratoActual)
    {
        $data = $this->getData();
        
        
        $operaciones = [
            // Cambio de tipo
            -1 => [
                // Cambio de estado
                -1 => [
                    'updateFechaFinContratoHistoricoAnterior',
                    'updateFechaFinEstadoContratoHistoricoAnterior',
                    'createContratoHistorico',
                ],
                // Se mantiene el estado
                0  => [
                    'updateFechaFinContratoHistoricoAnterior',
                    'createContratoHistorico',
                ],
            ],
            // Se mantiene el tipo
            0  => [
                // Cambio de estado
                -1 => [
                    'updateFechaFinEstadoContratoHistoricoAnterior',
                    'createContratoHistorico',
                ],
                // Se mantiene el estado
                0  => [
                    'updateContratoHistorico',
                ],
            ],
        ];
        
        
        $tipo   = ($contratoActual->tipoContrato->id - $this->tipo->id) ? -1 : 0;
        $estado = ($contratoActual->estadoContrato->id - $this->estado->id) ? -1 : 0;
        
        foreach ($operaciones[$tipo][$estado] as $operacion) {
            $this->{$operacion}($contratoActual);
        }
        
    }
    
    private function createContratoHistorico(Contrato $contratoActual)
    {
        ContratoHistorico::create(array_filter($this->getData()));
    }
    
    private function updateContratoHistorico(Contrato $contratoActual)
    {
        /** @var ContratoHistorico $historicoActual */
        $historicoActual = $this->agente->contratosHistoricos()
            ->orderBy('id', 'DESC')
            ->firstOrFail();
        
        $historicoActual->update(array_filter($this->getData()));
        
    }
    
    private function updateFechaFinContratoHistoricoAnterior(Contrato $contratoActual)
    {
        $historicoActual = $this->agente->contratosHistoricos()
            ->orderBy('id', 'DESC')
            ->first();

        if (!$historicoActual) {
            return;
        }
        
        
        $fechaFin = (new \DateTime($contratoActual->fecha_ingreso));
        $fechaFin->modify('-1day');
        
        $historicoActual->update([
            'fecha_fin' => $fechaFin->format('Y-m-d'),
        ]);
        
        
    }
    
    private function updateFechaFinEstadoContratoHistoricoAnterior(Contrato $contratoActual)
    {
        $historicoActual = $this->agente->contratosHistoricos()
            ->orderBy('id', 'DESC')
            ->first();

        if (!$historicoActual) {
            return;
        }
        
        $fechaFin = (new \DateTime($contratoActual->fecha_estado_desde));
        $fechaFin->modify('-1day');
        
        $historicoActual->update([
            'fecha_estado_hasta' => $fechaFin->format('Y-m-d'),
        ]);
    }
}