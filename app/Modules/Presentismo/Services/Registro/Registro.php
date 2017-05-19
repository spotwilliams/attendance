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
    
    /** @var  Presentismo */
    protected $presentismoPrevio;
    
    public function __construct(Agente $agente, TipoPresentismo $tipoPresentismo, \DateTime $fecha)
    {
        $this->agente           = $agente;
        $this->tipoPresentismo  = $tipoPresentismo;
        $this->jornadaLaborable = JornadaLaborableRepository::getOrCreate($fecha);
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
            if ($this->presenteYaFueCargado()) {
                // update en presentismo el id_tipo_presentsimo
                $this->updatePresentismoPrevio();
                // recuera el dia
                $this->updateDiasDisponibles($this->agente->id, $this->presentismoPrevio->id_tipo_presentismo, 1);
                
            } else {
                // Insert en presentismo y update dia disponible
                $this->savePresentismo();
            }
            // se quita el dia pedido
            $this->updateDiasDisponibles($this->agente->id, $this->tipoPresentismo->id, -1);
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    /**
     * @return bool
     */
    private function presenteYaFueCargado()
    {
        $this->presentismoPrevio = Presentismo::
        where('id_agente', '=', $this->agente->id)
            ->where('id_jornada', '=', $this->jornadaLaborable->id)
            ->first();
        
        return ($this->presentismoPrevio == null) ? false : true;
    }
    
    private function updatePresentismoPrevio()
    {
        Presentismo::where('id', '=', $this->presentismoPrevio->id)
            ->update(
                [
                    'id_tipo_presentismo' => $this->tipoPresentismo->id,
                ]
            );
    }
    
    private function savePresentismo()
    {
        Presentismo::create([
            'id_agente'           => $this->agente->id,
            'id_jornada'          => $this->jornadaLaborable->id,
            'id_tipo_presentismo' => $this->tipoPresentismo->id,
        ]);
    }
    
    private function updateDiasDisponibles($idAgente, $idTipoPresentismo, $add)
    {
        // Solo verificar que el tipo de presentismo este registrado
        $diaDisponible = DiaDisponible::where('id_agente', '=', $idAgente)
            ->where('id_tipo_presentismo', '=', $idTipoPresentismo)
            ->first();
        
        // en la tabla de dias disponibles. Las validaciones previas deben poder
        /** @var DiaDisponible $diaDisponible */
        if ($diaDisponible <> null) {
            $diaDisponible->cant_dias = $diaDisponible->cant_dias + $add;
            $diaDisponible->update();
        }
    }
    
}