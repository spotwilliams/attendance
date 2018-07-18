<?php

namespace Cat\Modules\Haberes\Controllers\Registro;



trait Ruleable
{
    protected $rules;
    protected $messages;
    
    protected function setRulesAccording()
    {
        $this->rules = $this->messages = [];
        
        $this->rules['agentes']     = 'required';
        $this->messages['required'] = 'Se debe seleccionar al menos un agente';
        
        return $this;
    }
}