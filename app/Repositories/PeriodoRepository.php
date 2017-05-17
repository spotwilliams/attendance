<?php

namespace Cat\Repositories;

use Cat\Models\Periodo;
use InfyOm\Generator\Common\BaseRepository;

class PeriodoRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Periodo::class;
    }
    
    public static function getOrCreatePeriodoActivo(\DateTime $fecha)
    {
        $periodo = Periodo::findActivo($fecha);
        
        if ($periodo == null) {
            // Buscar el ultimo periodo creado y crear uno a partir de este
            $ultimoPeriodo = Periodo::orderBy('fecha_fin', 'DESC')->first();
            
            $fechaInicio = new \DateTime($ultimoPeriodo->fecha_fin);
            $fechaInicio->modify("+1day");
            
            $fechaFin = new \DateTime($fechaInicio->format('Y-m-d'));
            $fechaFin->modify("+$ultimoPeriodo->cant_dias day");
            
            return Periodo::create([
                'fecha_inicio' => $fechaInicio->format('Y-m-d'),
                'fecha_fin'    => $fechaFin->format('Y-m-d'),
                'cant_dias'    => $ultimoPeriodo->cant_dias,
            ]);
        } else {
            return $periodo;
        }
    }
}
