<?php

namespace Cat\Modules\Presentismo\Services\Registro;

use Cat\Models\Agente;
use Cat\Models\Presentismo;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Service;
use Cat\Repositories\PeriodoRepository;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Registro extends Service
{
    /** @var Agente */
    protected $agente;
    
    /** @var TipoPresentismo */
    protected $tipoPresentismo;
    
    /** @var  JornadaLaborable */
    protected $jornadaLaborable;
    
    /** @var  Presentismo */
    protected $presentismoPrevio;
    
    protected $periodo;
    
    public function __construct(Agente $agente, TipoPresentismo $tipoPresentismo, \DateTime $fecha)
    {
        $this->agente           = $agente;
        $this->tipoPresentismo  = $tipoPresentismo;
        $this->jornadaLaborable = $fecha;
        $this->periodo          = PeriodoRepository::getOrCreatePeriodoActivo($fecha);
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
            
            // Busco o creo la asistencia
            /** @var Presentismo $presentismo */
            $presentismo = Presentismo::firstOrNew(
                [
                    'id_agente'  => $this->agente->id,
                    'fecha'      => $this->jornadaLaborable->format('Y-m-d'),
                    'id_periodo' => $this->periodo->id,
                ]);

            // Guardo el tipo de asistencia
            $presentismo->id_tipo_presentismo = $this->tipoPresentismo->id;
            
            // Justifico o no la misma
            $presentismo->injustificado = $this->tipoPresentismo->injustificado;
            
            $presentismo->save();
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    
}