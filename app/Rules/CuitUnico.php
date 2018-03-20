<?php

namespace Cat\Rules;


use Cat\Models\Agente;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CuitUnico
{
    /** @var Agente */
    protected $agente;
    
    /**
     * @param $attribute
     * @param $cuit
     * @return bool
     */
    public function validate($attribute, $cuit)
    {
        
        try {
            $this->agente = Agente::where('cuit', '=', $this->cleanMyInput($cuit))->firstOrFail();
            
            return false;
        } catch (ModelNotFoundException $noExisteCuit) {
            return true;
        }
    }
    
    /**
     * @param $input
     * @return string
     */
    protected function cleanMyInput($input)
    {
        $spec = [',', '-', '.'];
        
        $input = str_replace($spec, '', $input);
        
        return trim($input);
    }
    
    /**
     * @return string
     */
    public function message()
    {
        return "Ya existe un agente con ese CUIT: {$this->agente->apellido}, {$this->agente->nombre}.";
    }
}
