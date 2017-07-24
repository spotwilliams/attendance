<?php

namespace Cat\Helpers;


use Cat\Models\Agente;
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
    public static function getWeekends(\DateTime $start, \DateTime $end)
    {
        $days = [
            'Sat',
            'Sun',
        
        ];
        
        return self::getDays($start, $end, $days);
    }
    
    public static function getDays(\DateTime $start, \DateTime $end, $days)
    {
        // Se crean nuevamente los objetos para evitar cambiarlos
        $start      = new \DateTime($start->format('Y-m-d'));
        $end        = new \DateTime($end->format('Y-m-d'));
        
        $compulsory = [];
        
        $interval = new \DateInterval('P1D');
        $end->modify('+1day');
        $period = new \DatePeriod($start, $interval, $end);
        
        /** @var \DateTime $day */
        foreach ($period as $day) {
            
            if (in_array($day->format('D'), $days)) {
                $compulsory[] = $day->format('Y-m-d');
            }
        }
        
        return $compulsory;
    }
    
    public static function getWeekDays(\DateTime $start, \DateTime $end)
    {
        $days = [
            'Mon',
            'Tue',
            'Wed',
            'Thu',
            'Fri',
        
        ];
        
        return self::getDays($start, $end, $days);
    }
    
    public static function getAllDaysBetween(\DateTime $start, \DateTime $end)
    {
        $days = [
            'Mon',
            'Tue',
            'Wed',
            'Thu',
            'Fri',
            'Sat',
            'Sun',
        ];
        
        return self::getDays($start, $end, $days);
    }
    
    public static function addFaltasNoRegistradas(Collection $agentesConPresentsimos, $fechas = [])
    {
        /** @var Agente $agente */
        foreach ($agentesConPresentsimos as $agente) {
            
            $fechasResigradas = array_keys($agente->presentismos->keyBy('fecha')->toArray());
            $fechasQueFaltan  = array_diff($fechas, $fechasResigradas);
            /** @var Collection $presentismosGroupBy */
            $presentismosGroupBy = self::getPresentismoGroupByJustificacion($agente);
            
            foreach ($fechasQueFaltan as $fecha) {
                $presentismoARegistrar                  = new Presentismo([
                    'id_tipo_presentismo' => -1,
                    'fecha'               => $fecha,
                ]);
                $presentismosGroupBy['injustificado'][] = $presentismoARegistrar;
            }
            $agente->presentismos = $presentismosGroupBy->get('injustificado');
        }
        
        return $agentesConPresentsimos;
    }
    
    /**
     * Agrupa los presentismos si estan justificados. Genera collections en caso de empty
     * @param Agente $agente
     * @return mixed
     */
    private static function getPresentismoGroupByJustificacion(Agente $agente)
    {
        $presentismos = $agente->presentismos->groupBy(function ($item, $key) {
            return ($item->injustificado === true) ? 'injustificado' : 'justificado';
        });
        if ($presentismos->get('injustificado') === null) {
            $presentismos['injustificado'] = new Collection([]);
        }
        if ($presentismos->get('justificado') === null) {
            $presentismos['justificado'] = new Collection([]);
        }
        
        return $presentismos;
    }
}