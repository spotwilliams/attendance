<?php

namespace Cat\Repositories;

use Carbon\Carbon;
use Cat\Models\Base;
use Cat\Models\EstadoPeriodo;
use Cat\Models\JornadaLaborable;
use Cat\Models\Periodo;
use Cat\Models\Turno;
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
    
    /**
     * @param \DateTime $fecha
     * @return Periodo
     */
    public static function getOrCreatePeriodoActivo(\DateTime $fecha = null)
    {
        $periodo = Periodo::findActivo($fecha);
        
        
        if ($periodo == null) {
            
            if ($fecha === null) {
                $fecha = new Carbon();
            } else {
                $fecha = Carbon::createFromTimestamp($fecha->getTimestamp());
            }
            
            $start = Carbon::createFromTimestamp($fecha->getTimestamp());
            $end   = Carbon::createFromTimestamp($fecha->getTimestamp());
            
            // 2da quincena del mes, implica periodo nuevo
            if ($fecha->day >= config('cat.periodo_comienzo')) {
                $end->modify('+1month');
            } else {
                $start->modify('-1month');
            }
            $comienzoPeriodo = Carbon::create($start->year, $start->month, config('cat.periodo_comienzo'));
            $finPeriodo      = Carbon::create($end->year, $end->month, config('cat.periodo_fin'));
            
            $periodo = Periodo::create([
                'fecha_comienzo' => $comienzoPeriodo->format('Y-m-d'),
                'fecha_fin'      => $finPeriodo->format('Y-m-d'),
                'cant_dias'      => config('cat.periodo_comienzo'),
            ]);
            
        }
        
        return $periodo;
    }
    
    /**
     * Asigna el periodo activo a las bases
     * @param Periodo $periodo
     * @param Base|null $base si es null activa el periodo para todas las bases
     * @obsolete
     */
    public static function activarPeriodoEnBasesYTurnos(Periodo $periodo, Base $base = null, Turno $turno = null)
    {
        
        $bases  = ($base == null) ? Base::all(['id']) : [$base];
        $turnos = ($turno == null) ? Turno::all(['id']) : [$turno];
        foreach ($bases as $b) {
            foreach ($turnos as $t) {
                try {
                    $inserts = [
                        'id_base'    => $b->id,
                        'id_periodo' => $periodo->id,
                        'id_turno'   => $t->id,
                        'abierto'    => 1,
                    ];
                    EstadoPeriodo::create($inserts);
                } catch (QueryException $error) {
                    
                    Log::error($error);
                }
            }
        }
        
    }
    
    
    public static function getPeriodosActivosParaBase($idBase)
    {
        try {
            
            return Base::findOrFail($idBase)
                ->periodos()
                ->wherePivot('abierto', true)
                ->distinct('id_periodo')
                ->get();
            
        } catch (ModelNotFoundException $e) {
            return new Collection();
        }
    }
    
    /**
     * @param Base $base
     * @param Turno $turno
     * @return Collection{EstadoPeriodo}
     */
    public static function getPeriodosActivosParaBaseAndTurno(Base $base, Turno $turno)
    {
        try {
            $periodos = EstadoPeriodo::where('id_base', '=', $base->id)
                ->where('id_turno', '=', $turno->id)
                ->where('abierto', '=', true)
                ->with('periodo')
                ->get();
            
            return $periodos;
            
        } catch (ModelNotFoundException $e) {
            return new Collection();
        }
    }
    
    /**
     * @param Base $base
     * @param Turno $turno
     * @return Collection{EstadoPeriodo}
     */
    public static function getPeriodosParaBaseAndTurno(Base $base, Turno $turno, $limit = 1000)
    {
        try {
            $periodos = EstadoPeriodo::where('id_base', '=', $base->id)
                ->where('id_turno', '=', $turno->id)
                ->with('periodo')
                ->orderBy('id', 'desc')
                ->limit($limit)
                ->get();
            
            return $periodos;
            
        } catch (ModelNotFoundException $e) {
            return new Collection();
        }
    }
    
}
