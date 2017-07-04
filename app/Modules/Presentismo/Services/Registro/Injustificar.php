<?php

namespace Cat\Modules\Presentismo\Services\Registro;

use Cat\Models\Agente;
use Cat\Models\Presentismo;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Presentismo\Exceptions\Validacion\NoSePuedeInjustificar;
use Cat\Modules\Presentismo\Exceptions\Validacion\SinDiasDisponibles;
use Cat\Modules\Presentismo\Exceptions\Validacion\SinTopeONoEstablecido;
use Cat\Modules\Service;
use Cat\Modules\Validation\Rules\Ausente;
use Cat\Modules\Validation\Rules\PeriodoActivo;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Injustificar extends Service
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
        $this->presentismo = $presentismo;
        
    }
    
    public function execute()
    {
        /** @var TipoPresentismo $tipoPresentismo */
        $tipoPresentismo = $this->presentismo->tipoPresentismo()->first();
        if ($tipoPresentismo->puedoInjustificarlo()) {
            try {
                
                DB::beginTransaction();
                
                $this->presentismo->injustificado = true;
                $this->presentismo->save();
                DB::commit();
            } catch (QueryException $e) {
                DB::rollBack();
                throw $e;
            }
        } else {
            throw new NoSePuedeInjustificar($tipoPresentismo);
        }
    }
    
}