<?php

namespace Cat\Modules\Presentismo\Services\Registro;

use Cat\Models\Agente;
use Cat\Models\Contrato;
use Cat\Models\Operativo;
use Cat\Models\Presentismo;
use Cat\Models\TipoPresentismo;
use Cat\Models\Turno;
use Cat\Modules\Service;
use Cat\Repositories\PeriodoRepository;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Registro extends Service
{
    /** @var Agente */
    protected $agente;
    
    /** @var TipoPresentismo */
    protected $tipoPresentismo;
    
    /** @var  \DateTime */
    protected $jornadaLaborable;
    
    /** @var  Presentismo */
    protected $presentismoPrevio;
    
    /** @var \Cat\Models\Periodo */
    protected $periodo;
    
    /** @var Contrato */
    protected $contratoEnFecha;
    
    /** @var Turno */
    protected $turnoEnFecha;
    
    /**
     * Registro constructor.
     * @param Agente $agente
     * @param TipoPresentismo $tipoPresentismo
     * @param \DateTime $fecha
     */
    public function __construct(Agente $agente, TipoPresentismo $tipoPresentismo, \DateTime $fecha)
    {
        $this->agente           = $agente;
        $this->tipoPresentismo  = $tipoPresentismo;
        $this->jornadaLaborable = $fecha;
        $this->periodo          = PeriodoRepository::getOrCreatePeriodoActivo($fecha);
        
        $this->contrato = $this->agente->contratoOnDate($this->jornadaLaborable)
            ->with('estadoContrato')
            ->with('tipoContrato')
            ->first();
        
        /** @var  Operativo $operativo */
        $operativo = $this->agente->operativo()->first();
        
        if ($operativo) {
            $this->turnoEnFecha = $operativo->turnoOnDate($this->jornadaLaborable)
                ->first();
        }
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
            
            // Guardo los datos de trazabilidad de contrato y turno
            $presentismo->id_estado_contrato = ($this->contratoEnFecha !== null) ? $this->contratoEnFecha->estdoContrato->id : null;
            $presentismo->id_tipo_contrato   = ($this->contratoEnFecha !== null) ? $this->contratoEnFecha->tipoContrato->id : null;
            $presentismo->id_turno           = ($this->turnoEnFecha !== null) ? $this->turnoEnFecha->id_turno : null;
            
            $presentismo->save();
            DB::commit();
            
        } catch (QueryException $e) {
            Log::error($e);
            DB::rollBack();
            throw $e;
        }
    }
    
}