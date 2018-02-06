<?php

namespace Cat\Modules\Agentes\Repositories;

use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\Operativo;
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
    
}
