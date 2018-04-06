<?php

namespace Cat\Modules\Presentismo\Services\Registro;

use Cat\Models\Agente;
use Cat\Models\Presentismo;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Presentismo\Exceptions\Validacion\NoSePuedeJustificar;
use Cat\Modules\Presentismo\Exceptions\Validacion\SinDiasDisponibles;
use Cat\Modules\Presentismo\Exceptions\Validacion\SinTopeONoEstablecido;
use Cat\Modules\Service;
use Cat\Modules\Validation\Rules\Ausente;
use Cat\Modules\Validation\Rules\PeriodoActivo;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Justificar extends Service
{
    /** @var Presentismo */
    protected $presentismo;
    
    /** @var  Agente */
    protected $agente;
    
    /** @var  Ausente */
    protected $ruleAusente;
    
    /** @var  PeriodoActivo */
    protected $rulePeriodoActivo;
    
    public function __construct(Presentismo $presentismo)
    {
        $this->presentismo       = $presentismo;
        $this->agente            = $presentismo->agente()->first();
        $this->ruleAusente       = new Ausente($this->agente, $this->presentismo->tipoPresentismo()->first(), new \DateTime($this->presentismo->fecha));
        $this->rulePeriodoActivo = new PeriodoActivo($this->agente, $this->presentismo->tipoPresentismo()->first(),
            new \DateTime($this->presentismo->fecha));
        
    }
    
    /**
     * @throws NoSePuedeJustificar
     * @throws \Cat\Modules\Presentismo\Exceptions\Validacion\Validation
     */
    public function execute()
    {
        /** @var TipoPresentismo $tipoPresentismo */
        $tipoPresentismo = $this->presentismo->tipoPresentismo()->first();
        if ($tipoPresentismo->puedoJustificarlo()) {
            $this->rulePeriodoActivo->check();
            $this->ruleAusente->check();
            $this->save();
        } else {
            throw new NoSePuedeJustificar($tipoPresentismo);
        }
    }
    
    private function save()
    {
        try {
            
            DB::beginTransaction();
            $this->presentismo->injustificado = false;
            $this->presentismo->save();
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
}