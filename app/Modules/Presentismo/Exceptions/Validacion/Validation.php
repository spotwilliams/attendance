<?php

namespace Cat\Modules\Presentismo\Exceptions\Validacion;


use Cat\Models\Agente;
use Cat\Modules\Validation\Rules\Ausente;

class Validation extends \Exception
{
    const CONTRATO_INACTIVO = 1000;
    
    protected $agente;
    protected $tipoAusencia;
    
    public function __construct(Agente $agente, Descriptor $errorDescriptor, Ausente $tipoAusencia = null)
    {
        $this->agente       = $agente;
        $this->tipoAusencia = $tipoAusencia;
        parent::__construct($errorDescriptor->getDescription(), $errorDescriptor->getCode(), $this);
    }
    
    
}