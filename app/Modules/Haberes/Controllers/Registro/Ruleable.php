<?php

namespace Cat\Modules\Haberes\Controllers\Registro;


use Illuminate\Http\Request;

trait Ruleable
{
    protected $rules;
    protected $messages;
    
    protected function setRulesAccording(Request $request)
    {
        $this->rules = $this->messages = [];
        $facturas    = $request->input('facturas');
        
        if ($facturas) {
            $this->rules['facturas.*']    = 'required';
            $this->messages['facturas.*'] = 'Cada agente seleccionado debe tener un nro. de factura';
        } else {
            $this->rules['facturas']    = 'required';
            $this->messages['required'] = 'Se debe seleccionar al menos un agente';
        }
        
        return $this;
    }
}