<?php

namespace Cat\Modules\Presentismo\Services\Registro;


use Cat\Models\Agente;
use Cat\Models\DiaDisponible;
use Cat\Models\JornadaLaborable;
use Cat\Models\Presentismo;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Service;
use Cat\Repositories\JornadaLaborableRepository;
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
    
    
    public function __construct(Agente $agente, TipoPresentismo $tipoPresentismo, \DateTime $fecha)
    {
        $this->agente           = $agente;
        $this->tipoPresentismo  = $tipoPresentismo;
        $this->jornadaLaborable = JornadaLaborableRepository::getOrCreate($fecha);
    }
    
    public function execute()
    {
        try {
            DB::beginTransaction();
            
            $this->savePresentismo();
            $this->updateDiasDisponibles();
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
        }
    }
    
    private function savePresentismo()
    {
        $presentismo                      = new Presentismo();
        $presentismo->id_agente           = $this->agente->id;
        $presentismo->id_jornada          = $this->jornadaLaborable->id;
        $presentismo->id_tipo_presentismo = $this->tipoPresentismo->id;
        
        $presentismo->save();
    }
    
    private function updateDiasDisponibles()
    {
        // Solo verificar que el tipo de presentismo este registrado
        // en la tabla de dias disponibles. Las validaciones previas deben poder
        /** @var DiaDisponible $diaDisponible */
        $diaDisponible = DiaDisponible::where('id_agente', '=', $this->agente->id)
            ->where('id_tipo_presentismo', '=', $this->tipoPresentismo->id)->first();
        
        if ($diaDisponible <> null) {
            $diaDisponible->cant_dias = $diaDisponible->cant_dias - 1;
            $diaDisponible->save();
        }
    }
    
}