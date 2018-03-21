<?php

namespace Cat\Modules\Agentes\Services\Registro\Store;


use Cat\Models\Agente;
use Cat\Models\Contrato;
use Cat\Models\ContratoHistorico;
use Cat\Modules\Agentes\Services\Registro\Traits\LaboralesSetup;
use Cat\Modules\Service;
use Illuminate\Support\Facades\DB;

class Laborales extends Service
{
    use LaboralesSetup;
    
    
    public function __construct(Agente $agente, $input)
    {
        // Shared with Updater
        $this->setup($agente, $input);
    }
    
    /**
     * @return Agente
     * @throws \Exception
     */
    public function execute()
    {
        
        try {
            
            DB::beginTransaction();
            
            $data = $this->getData();
            
            /** @var Contrato $contrato */
            Contrato::create(array_filter($data));
            
            ContratoHistorico::create(array_filter($data));
            
            DB::commit();
            
            return $this->agente;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
}