<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 6/14/17
 * Time: 15:00
 */

namespace Cat\Modules\Presentismo\Exceptions\Validacion;

use Cat\Models\Agente;
use Cat\Models\TipoPresentismo;

class SinDiasDisponibles extends Validation
{
    
    /** @var  \DateTime */
    protected $fecha;
    
    
    public function __construct(Agente $agente, TipoPresentismo $tipoPresentismo)
    {
        parent::__construct($agente, Descriptor::noTieneDiasDisponibles(), $tipoPresentismo);
    }
}