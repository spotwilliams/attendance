<?php

namespace Cat\Helpers;


class Calculation
{
    const MAX_DIFF_BETWEEN_DATES = 8;
    
    /**
     * @param $start string YYYY-MM-DD
     * @param $end string YYYY-MM-DD
     * @return array
     */
    public static function prepareTenDaysDiff($start, $end)
    {
        $start = self::getDateOrNow($start);
        $end   = self::getDateOrNow($end);
        $diff  = (int)$start->diff($end)->format("%r%a");
        
        // Ubicamos las fechas segun su valor
        if ($diff < 0) {
            $aux   = $start;
            $start = $end;
            $end   = $aux;
        }
        
        // Verificamos que solo sean 10 dias de diferencia
        $diff = (int)$start->diff($end)->format("%r%a");
        if ($diff > self::MAX_DIFF_BETWEEN_DATES) {
            $end = new \DateTime($start->format('Y-m-d'));
            $end->modify('+' . self::MAX_DIFF_BETWEEN_DATES . 'day');
        }
        
        return [
            'desde' => $start,
            'hasta' => $end,
        ];
    }
    
    public static function getDateOrNow($date)
    {
        try {
            return new \DateTime($date);
        } catch (\Exception $e) {
            return new \DateTime('now');
        }
    }
}