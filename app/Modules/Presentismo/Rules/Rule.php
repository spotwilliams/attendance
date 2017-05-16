<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 5/5/17
 * Time: 12:13
 */

namespace Cat\Modules\Validation\Rules;


use Cat\Models\Agente;
use Cat\Modules\Validation\Exceptions\Validation;
use Cat\Models\Ausente;
abstract class Rule
{
    
    /** @var  Agente */
    protected $agente;
    
    /** @var  Ausente */
    protected $tipoAusente;
    
    /**
     * Rule constructor.
     * @param Agente $agente
     */
    public function __construct(Agente $agente, Ausente $tipoAusente)
    {
        $this->agente      = $agente;
        $this->tipoAusente = $tipoAusente;
    }
    
    /**
     * Metodo que se debe implementar en las hijas por cada regla propia
     * @return mixed
     */
    protected abstract function validate();
    
    public function check()
    {
        try {
            $this->validate();
        } catch (Validation $notAccomplish) {
            Log::info('Agente No paso validacion: ' . $this->agente->id);
        }
        
        return $this;
    }
}