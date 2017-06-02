<?php

namespace Cat\Modules\Agentes\Repositories;

use Cat\Models\Agente;
use Cat\Models\Base;
use InfyOm\Generator\Common\BaseRepository;

class AgenteRepository extends BaseRepository
{
    public function model()
    {
        return Agente::class;
    }
    
    
    public function getAgentesByBase($idBase)
    {
        /** @var Base $base */
        $base    = Base::find($idBase);
        $agentes = [];
        
        if ($base !== null) {
            
            return $base->agentes()->get();
        } else {
            return $agentes;
        }
        
    }
    
    
}
