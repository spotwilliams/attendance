<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 5/5/17
 * Time: 12:13
 */

namespace Cat\Modules\Validation\Rules;


use Cat\Models\Agente;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Presentismo\Exceptions\Validacion\Validation;
use Cat\Models\Ausente;
use Illuminate\Support\Facades\Log;

abstract class Rule
{
    
    /** @var  Agente */
    protected $agente;
    
    /** @var  TipoPresentismo */
    protected $tipoAusente;
    
    /**
     * Rule constructor.
     * @param Agente $agente
     */
    public function __construct(Agente $agente, TipoPresentismo $tipoAusente)
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
            throw $notAccomplish;
        }
        
        return true;
    }
}