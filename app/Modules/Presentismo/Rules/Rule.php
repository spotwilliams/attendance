<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 5/5/17
 * Time: 12:13
 */

namespace Cat\Modules\Presentismo\Rules;


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
    
    /** @var  \DateTime */
    protected $fecha;
    
    /**
     * Rule constructor.
     * @param Agente $agente
     * @param TipoPresentismo $tipoAusente
     * @param \DateTime|null $fecha
     */
    public function __construct(Agente $agente, TipoPresentismo $tipoAusente, \DateTime $fecha = null)
    {
        $this->agente      = $agente;
        $this->tipoAusente = $tipoAusente;
        $this->fecha       = $fecha;
    }
    
    /**
     * Metodo que se debe implementar en las hijas por cada regla propia
     * @return mixed
     */
    protected abstract function validate();
    
    public function check()
    {
        try {
            return $this->validate();
        } catch (Validation $notAccomplish) {
            throw $notAccomplish;
        }
    }
}
