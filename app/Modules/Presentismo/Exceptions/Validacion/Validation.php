<?php

namespace Cat\Modules\Presentismo\Exceptions\Validacion;


use Cat\Models\Agente;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Presentismo\Exceptions\Descriptor;

class Validation extends \Exception
{
    
    protected $agente;
    protected $tipoAusencia;
    
    protected $errorDescriptor;
    
    public function __construct(Agente $agente, Descriptor $errorDescriptor, TipoPresentismo $tipoAusencia = null)
    {
        $this->agente          = $agente;
        $this->tipoAusencia    = $tipoAusencia;
        $this->errorDescriptor = $errorDescriptor;
        parent::__construct($errorDescriptor->getDescription(), $errorDescriptor->getCode(), $this);
    }
    
    
}