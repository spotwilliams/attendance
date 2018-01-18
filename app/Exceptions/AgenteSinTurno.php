<?php

namespace Cat\Exceptions;


use Cat\Models\Agente;

class AgenteSinTurno extends FaltanDatosObligatorios
{
    
    protected $agente;
    
    public function __construct(Agente $agente, $contexto = [])
    {
        $this->agente = $agente;
        parent::__construct('El agente no tiene asignado un turno.', $contexto);
    }
}