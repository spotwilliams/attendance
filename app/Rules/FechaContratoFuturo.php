<?php

namespace Cat\Rules;


use Carbon\Carbon;

class FechaContratoFuturo
{
    
    /**
     * @param string $attribute
     * @param string $fecha
     * @return bool
     */
    public function validate($attribute, $fecha)
    {
        $today = \Illuminate\Support\Facades\Date::today();
        $fecha = \Illuminate\Support\Facades\Date::createFromFormat('Y-m-d', (new \DateTime($fecha))->format('Y-m-d'));

        if ($fecha->gt($today)) {
            // Implica que le fecha de contrato es a futuro
            return false;
        } else {
            return true;
        }
        
    }
    
    
}
