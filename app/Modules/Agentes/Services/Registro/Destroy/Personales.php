<?php

namespace Cat\Modules\Agentes\Services\Registro\Destroy;


use Cat\Models\Agente;
use Cat\Models\DiaDisponible;
use Cat\Models\Domicilio;
use Cat\Models\Estudio;
use Cat\Models\JornadaLaborable;
use Cat\Models\Presentismo;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Service;
use Cat\Repositories\JornadaLaborableRepository;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Personales extends Service
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
                ->domicilios()
                ->delete();
            
            $this->agente
                ->estudio()
                ->delete();
            
            $this->agente
                ->delete();
            
            DB::commit();
            
            return $this->agente;
        } catch (QueryException $e) {
            
            DB::rollBack();
            throw $e;
        }
    }
    
}