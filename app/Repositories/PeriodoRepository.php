<?php

namespace Cat\Repositories;

use Cat\Models\Base;
use Cat\Models\EstadoPeriodo;
use Cat\Models\JornadaLaborable;
use Cat\Models\Periodo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            $ultimoPeriodo = Periodo::getUltimoPeriodo();
            
            $fechaInicio = new \DateTime($ultimoPeriodo->fecha_fin);
            $fechaInicio->modify("+1day");
            
            $fechaFin = new \DateTime($fechaInicio->format('Y-m-d'));
            $fechaFin->modify("+$ultimoPeriodo->cant_dias day");
            
            $periodo = Periodo::create([
                'fecha_comienzo' => $fechaInicio->format('Y-m-d'),
                'fecha_fin'      => $fechaFin->format('Y-m-d'),
                'cant_dias'      => $ultimoPeriodo->cant_dias,
            ]);
            static::activarPeriodoEnBases($periodo);
        }
        
        return $periodo;
    }
    
    /**
     * Asigna el periodo activo a las bases
     * @param Periodo $periodo
     * @param Base|null $base si es null activa el periodo para todas las bases
     */
    public static function activarPeriodoEnBases(Periodo $periodo, Base $base = null)
    {
        
        $bases = ($base == null) ? Base::all(['id']) : [$base];
        foreach ($bases as $b) {
            try {
                $inserts = [
                    'id_base'    => $b->id,
                    'id_periodo' => $periodo->id,
                    'abierto'    => 1,
                ];
                EstadoPeriodo::create($inserts);
            } catch (QueryException $error) {
                Log::error($error);
            }
        }
        
    }
    
    
    public static function getPeriodosActivosParaBase($idBase)
    {
        try {
            
            return Base::findOrFail($idBase)
                ->periodos()
                ->wherePivot('abierto', 1)
                ->get();
            
        } catch (ModelNotFoundException $e) {
            return new Collection();
        }
    }
    
}
