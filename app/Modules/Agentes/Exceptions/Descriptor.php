<?php

namespace Cat\Modules\Agentes\Exceptions;

use Cat\Exceptions\MainDescriptor;

class Descriptor extends MainDescriptor
{
    const AGENTE_YA_EXISTE = 1000;
    
    public static function agenteYaExiste()
    {
        if (!isset(self::$errorMap[Descriptor::AGENTE_YA_EXISTE])) {
            self::$errorMap[Descriptor::AGENTE_YA_EXISTE]
                = new Descriptor(Descriptor::AGENTE_YA_EXISTE,
                'Ya existe un agente con el mismo CUIT');
        }
        
        return self::$errorMap[Descriptor::AGENTE_YA_EXISTE];
    }
}