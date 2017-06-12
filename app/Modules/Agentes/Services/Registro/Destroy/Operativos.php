<?php

namespace Cat\Modules\Agentes\Services\Registro\Destroy;

use Cat\Models\Agente;
use Cat\Modules\Service;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Operativos extends Service
{
    /** @var Agente */
    protected $agente;
    
    public function __construct(Agente $agente)
    {
        
        $this->agente = $agente;
    }
    
    public function execute()
    {
        
        try {
            DB::beginTransaction();
            
            $this->agente
                ->operativo()
                ->delete();
            
            DB::commit();
            
            return $this->agente;
        } catch (QueryException $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
}