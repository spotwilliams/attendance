<?php

namespace Cat\Helpers;


use Cat\Models\Presentismo;
use Illuminate\Support\Collection;

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
    
    public static function transformCabaDate($dMY)
    {
        $dMY = explode('/', $dMY);
        
        return $dMY[2] . '-' . $dMY[1] . '-' . $dMY[0];
    }
    
    /**
     * Devuelve una lista con las fechas de fin de semana en un periodo
     * @param \DateTime $start
     * @param \DateTime $end
     * @return array
     */
    public static function getWeekends(\DateTime $start, \DateTime $end, $daysFiltered = [])
    {
        $days = [
            'Sat',
            'Sun',
        
        ];
        if (!empty($daysFiltered)) {
            $days = $daysFiltered;
        }
        $compulsory = [];
        
        $interval = new \DateInterval('P1D');
        
        $period = new \DatePeriod($start, $interval, $end);
        
        /** @var \DateTime $day */
        foreach ($period as $day) {
            if (in_array($day->format('D'), $days, true)) {
                $compulsory[] = $day->format('Y-m-d');
            }
        }
        
        return $compulsory;
    }
    
    public static function getWeekDays(\DateTime $start, \DateTime $end, $daysFiltered = [])
    {
        $days = [
            'Mon',
            'Tue',
            'Wed',
            'Thu',
            'Fri',
        
        ];
        if (!empty($daysFiltered)) {
            $days = $daysFiltered;
        }
        $compulsory = [];
        $interval   = new \DateInterval('P1D');
        
        $period = new \DatePeriod($start, $interval, $end);
        
        /** @var \DateTime $day */
        foreach ($period as $day) {
            if (in_array($day->format('D'), $days, true)) {
                $compulsory[] = $day->format('Y-m-d');
            }
        }
        
        return $compulsory;
    }
    
    
    public static function addFaltasNoRegistradas(Collection $agentesConPresentsimos, $fechas = [])
    {
        
        foreach ($agentesConPresentsimos as $agente) {
            
            $fechasResigradas = array_keys($agente->presentismos->keyBy('fecha')->toArray());
            $fechasQueFaltan  = array_diff($fechas, $fechasResigradas);
            
            foreach ($fechasQueFaltan as $fecha) {
                $presentismoARegistrar = new Presentismo([
                    'id_tipo_presentismo' => -1,
                    'fecha'               => $fecha,
                ]);
                $agente->presentismos->add($presentismoARegistrar);
            }
        }
        
        return $agentesConPresentsimos;
    }
}