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
        
        if (strtoupper($this->codigo) === parent::INJUSTIFICADO) {
            return true;
        } else {
            $padre = $this->padre()->first();

            return strtoupper($padre->codigo) === parent::INJUSTIFICADO;
        }
    }
    
    
}
