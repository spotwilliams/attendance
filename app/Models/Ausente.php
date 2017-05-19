<?php

namespace Cat\Models;

class Ausente extends TipoPresentismo
{
    
    
    /**
     * @return Ausente
     */
    public function getInjustificado()
    {
        return TipoPresentismo::where('tipo', '=', TipoPresentismo::INJUSTIFICADO)->first();
    }
    
    /**
     * @return bool
     */
    public function esInjustificado()
    {
        return (strtoupper($this->codigo) === parent::INJUSTIFICADO);
    }
    

}
