<?php

namespace Cat\Modules\Haberes\Services\Modificador;

use Cat\Models\Contrato;
use Cat\Models\Operativo;
use Cat\Modules\Service;
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
    
    
    public function execute()
    {
        try {
            DB::beginTransaction();
            /** @var array $agentes */
            $agentes = Operativo::select(['id_agente'])
                ->whereIn('id_gerencia', $this->gerencias)
                ->get()
                ->pluck('id_agente');
            

            Contrato::whereIn('id_agente', $agentes)
                ->update([
                    'monto' => $this->monto,
                    'fecha_ingreso' => $this->fechaContrato->format('Y-m-d')
                ]);
            
            DB::commint();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    
}