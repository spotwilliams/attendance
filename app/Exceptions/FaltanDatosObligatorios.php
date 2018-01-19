<?php

namespace Cat\Exceptions;


class FaltanDatosObligatorios extends \Exception
{
    
    protected $contexto;
    
    public function __construct($message, $contexto = [])
    {
        $this->contexto = $contexto;
        parent::__construct($message);
    }
}