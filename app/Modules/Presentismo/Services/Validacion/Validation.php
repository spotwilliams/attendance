<?php

namespace Cat\Modules\Presentismo\Services\Validacion;

use Cat\Models\Agente;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Validation\Rules\EnComision;
use Cat\Modules\Validation\Rules\NoEsFuturo;
use Cat\Modules\Service;
use Cat\Modules\Validation\Rules\Ausente;
use Cat\Modules\Validation\Rules\PeriodoActivo;
use Cat\Modules\Validation\Rules\Presente;
use Cat\Modules\Validation\Rules\Rule;

class Validation extends Service
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
            // Revision de tipo de contratos y periodo
            (
                $this->rulesExecuter(PeriodoActivo::class)
                and
                $this->rulesExecuter(NoEsFuturo::class)
                and
                $this->rulesExecuter(EnComision::class)
            
            )
            and
            // Reviso los tipos de Presentismo
            // Si es un presente no hace falta controlar otra cosa
            ($this->rulesExecuter(Presente::class)
                or
                // Se revisan todos los tipos de ausentes
                ($this->rulesExecuter(Ausente::class))
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