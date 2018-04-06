<?php

namespace Cat\Http\Requests;

use Carbon\Carbon;
use Cat\Helpers\Validation;
use Cat\Models\Agente;
use Cat\Models\EstadoContrato;

class LaboralesRequestUpdate extends LaboralesRequest
{
    
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        $rules  = Validation::getContratoRules($this);
        $agente = Agente::where('id', '=', $this->input('agente'))
            ->with('contrato')
            ->first();
        if (($agente !== null) and ($agente->contrato->fecha_ingreso === $this->input('fecha_ingreso'))) {
            $rules['fecha_ingreso'] = 'required|date|fecha_contrato_futuro';
        } else {
            
            $rules['fecha_ingreso'] = 'required|date|fecha_contrato_futuro|fecha_contrato';
        }
        
        return $rules;
    }
    
    public function validate()
    {
        parent::validate();
        
        $this->validateFechasIngreso();
        
        $this->validateFechasComision();
    }
    
}
