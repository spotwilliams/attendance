<?php

namespace Cat\Modules\Haberes\Exceptions\Validacion;


use Cat\Models\Agente;
use Cat\Models\TipoPresentismo;

class Validation extends \Exception
{
    const CONTRATO_INACTIVO = 1000;
    
    protected $agente;
    protected $tipoAusencia;
    
    public function __construct(Agente $agente, Descriptor $errorDescriptor, TipoPresentismo $tipoAusencia = null)
    {
        $this->agente       = $agente;
        $this->tipoAusencia = $tipoAusencia;
        parent::__construct($errorDescriptor->getDescription(), $errorDescriptor->getCode(), $this);
    }
    
    
}