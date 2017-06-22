<?php

namespace Cat\Modules\Agentes\Exceptions\Registro;

use Cat\Models\Agente;
use Cat\Modules\Agentes\Exceptions\Descriptor;
use Cat\Modules\Agentes\Exceptions\Exception;

class EntidadDuplicada extends Exception
{
    
    /** @var  Agente */
    protected $agente;
    
    protected $descriptor;
    
    public function __construct(Agente $agente)
    {
        parent::__construct($agente, Descriptor::agenteYaExiste());
    }
    
}