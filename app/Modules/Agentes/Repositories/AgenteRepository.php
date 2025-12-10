<?php

namespace Cat\Modules\Agentes\Repositories;

use Arcanedev\Support\Collection;
use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\EstadoContrato;
use Cat\Models\Operativo;
use Cat\Models\Param;
use Cat\Models\Turno;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use InfyOm\Generator\Common\BaseRepository;

class AgenteRepository extends BaseRepository
{
    public function model()
    {
        return Agente::class;
    }
    
    
    public function getAgentesByBase($idBase)
    {
        
        $agentes = new LengthAwarePaginator([], 0, 1);
        try {
            /** @var Base $base */
            $base    = Base::findOrFail($idBase);
            $agentes = $base->agentes()->paginate(25);
        } catch (ModelNotFoundException $e) {
        
        }
        
        return $agentes;
    }
    
    public function findBy($criteria = [])
    {
        return Agente::with('area')
            ->paginate(25);
    }
    
    public static function getAgentesByBaseByTurno(Base $base, Turno $turno)
    {
        $agentes = Operativo::where('id_base', '=', $base->id)
            ->where('id_turno', '=', $turno->id)
            ->with('agente');
        try {
            return $agentes->get();
        } catch (QueryException $e) {
            return [];
        }
    }
    
    /**
     * @return integer
     */
    public static function getCountActivos()
    {
        $agentesActivo = Agente::whereHas('contrato', function ($where): void {
            /** @var Collection $activos */
            $activos = EstadoContrato::getEstadosEquivalentesActivos();
            $where->whereIn('id_estado_contrato', $activos->pluck('id')->toArray());
            
        })->count();
        
        return $agentesActivo;
    }
    
    public static function storeCountActivos(\DateTime $fecha = null)
    {
        $fecha = $fecha ? $fecha : new \DateTime('now');
        try {
            $param = Param::where('param', '=', Param::CANT_ACTIVOS)
                ->whereDate('created_at', '=', $fecha)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $param = new Param([
                'param'       => Param::CANT_ACTIVOS,
                'descripcion' => 'Cantidad de agentes activos',
            ]);
        }
        
        $param->fill([
            'valor' => self::getCountActivos(),
        ])
            ->save();
        
        
    }
    
}
