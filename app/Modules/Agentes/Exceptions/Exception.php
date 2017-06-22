<?php

namespace Cat\Modules\Agentes\Exceptions;

use Cat\Models\Agente;

class Exception extends \Exception
{
    
    /** @var  Agente */
    protected $agente;
    
    protected $descriptor;
    
    public function __construct(Agente $agente, Descriptor $descriptor)
    {
        $this->descriptor = $descriptor;
        parent::__construct($this->descriptor->getDescription(), $this->descriptor->getCode(), $this);
    }
    
}