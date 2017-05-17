<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 5/5/17
 * Time: 11:19
 */

namespace Cat\Modules\Presentismo\Services\Validacion;


use Cat\Models\Agente;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Service;
use Cat\Modules\Validation\Rules\Ausente;
use Cat\Modules\Validation\Rules\ContratoActivo;
use Cat\Modules\Validation\Rules\ContratoLocacion;
use Cat\Modules\Validation\Rules\PeriodoActivo;
use Cat\Modules\Validation\Rules\Presente;
use Cat\Modules\Validation\Rules\Rule;

class Validation extends Service
{
    protected $agente;
    protected $tipoPresentismo;
    protected $rulesScheduler
        = [
            ContratoActivo::class   => ContratoActivo::class,
            ContratoLocacion::class => ContratoLocacion::class,
            Presente::class         => Presente::class,
            Ausente::class          => Ausente::class,
            PeriodoActivo::class    => PeriodoActivo::class,
        
        ];
    
    public function __construct(Agente $agente, TipoPresentismo $tipoPresentismo)
    {
        $this->agente          = $agente;
        $this->tipoPresentismo = $tipoPresentismo;
        
    }
    
    /**
     * @return bool
     */
    public function execute()
    {
        return (
            $this->rulesExecuter(ContratoActivo::class)
            and $this->rulesExecuter(ContratoLocacion::class)
            and $this->rulesExecuter(Ausente::class));
        
    }
    
    private function rulesExecuter($ruleName)
    {
        /** @var Rule $rule */
        $rule = new $ruleName ($this->agente, $this->tipoPresentismo);
        
        return $rule->check();
    }
    
}