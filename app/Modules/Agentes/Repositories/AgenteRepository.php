<?php

namespace Cat\Modules\Agentes\Repositories;

use Cat\Models\Agente;
use Cat\Models\Base;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InfyOm\Generator\Common\BaseRepository;

class AgenteRepository extends BaseRepository
{
    public function model()
    {
        return Agente::class;
    }
    
    
    public function getAgentesByBase($idBase)
    {
        
        $agentes = [];
        try {
            /** @var Base $base */
            $base    = Base::findOrFail($idBase);
            $agentes = $base->agentes()->paginate(50);
        } catch (ModelNotFoundException $e) {
        
        }
        
        return $agentes;
    }
    
    public function findBy($criteria = [])
    {
        return Agente::with('area')
            ->paginate(25);
    }
    
    
}
