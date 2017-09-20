<?php

namespace Cat\Modules\Presentismo\Services\Registro;

use Cat\Models\Agente;
use Cat\Models\Comentario;
use Cat\Models\Presentismo;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Service;
use Cat\Repositories\PeriodoRepository;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Destroy extends Service
{
    /** @var Agente */
    protected $agente;
    
    /** @var  Presentismo */
    protected $presentismoPrevio;
    
    protected $periodo;
    
    public function __construct(Agente $agente, \DateTime $fecha)
    {
        $this->agente           = $agente;
        $this->jornadaLaborable = $fecha;
        $this->periodo          = PeriodoRepository::getOrCreatePeriodoActivo($fecha);
    }
    
    public function execute()
    {
        
        try {
            
            DB::beginTransaction();
            
            /** @var Presentismo $presentismos */
            $presentismo = Presentismo::where('id_agente', '=', $this->agente->id)
                ->whereDate('fecha', '=', $this->jornadaLaborable->format('Y-m-d'))
                ->first();
            
            // Borro los comentarios del presente
            Comentario::where('id_presentismo', '=', $presentismo->id)
                ->delete();
            
            // Borro el presente
            $presentismo->delete();
            
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    
}