<?php

namespace Cat\Rules;


use Carbon\Carbon;

class FechaContrato
{
    
    /**
     * @param $attribute
     * @param $fecha
     * @return bool
     */
    public function validate($attribute, $fecha)
    {
        $today = \Illuminate\Support\Facades\Date::today();
        
        $fecha = \Illuminate\Support\Facades\Date::createFromFormat('Y-m-d', (new \DateTime($fecha))->format('Y-m-d'));
        
        /** @var \DateInterval $diff */
        $diff = (int) $fecha->diffInDays($today);
        
        if ($diff > config('cat.fecha_contrato_registro')) {
            return false;
        } else {
            return true;
        }
    }
    
    
}
