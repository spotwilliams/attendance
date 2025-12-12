<?php

namespace Cat\Modules\Presentismo\Services\Validacion;

use Cat\Models\Agente;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Presentismo\Rules\NoEsFuturo;
use Cat\Modules\Service;
use Cat\Modules\Presentismo\Rules\Ausente;
use Cat\Modules\Presentismo\Rules\PeriodoActivo;
use Cat\Modules\Presentismo\Rules\Presente;
use Cat\Modules\Presentismo\Rules\Rule;

class ValidationNonType extends Service
{
    protected $agente;
    protected $tipoPresentismo;
    protected $fecha;
    
    /**
     * Validation constructor.
     * @param Agente $agente
     * @param TipoPresentismo $tipoPresentismo Tipo de presentismo a controlar
     * @param \DateTime $fecha fecha elegida
     */
    public function __construct(Agente $agente, TipoPresentismo $tipoPresentismo, \DateTime $fecha)
    {
        $this->agente          = $agente;
        $this->tipoPresentismo = $tipoPresentismo;
        $this->fecha           = $fecha;
    }
    
    /**
     * @return bool
     */
    public function execute()
    {
        return (
        (
            $this->rulesExecuter(PeriodoActivo::class)
            and
            $this->rulesExecuter(NoEsFuturo::class)
        
        )
        );
        
    }
    
    private function rulesExecuter($ruleName)
    {
        /** @var Rule $rule */
        $rule = new $ruleName ($this->agente, $this->tipoPresentismo, $this->fecha);
        
        return $rule->check();
    }
    
}
