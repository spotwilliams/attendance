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
        $today = Carbon::today();
        
        $fecha = Carbon::createFromFormat('Y-m-d', (new \DateTime($fecha))->format('Y-m-d'));
        
        /** @var \DateInterval $diff */
        $diff = $fecha->diffInDays($today, false);
        
        if ($diff > config('cat.fecha_contrato_registro')) {
            return false;
        } else {
            return true;
        }
    }
    
    
}
