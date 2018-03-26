<?php

namespace Cat\Http\Requests;

use Carbon\Carbon;
use Cat\Helpers\Validation;
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
        $rules                  = Validation::getContratoRules($this);
        $rules['fecha_ingreso'] = 'required|date|fecha_contrato_futuro';
        
        return $rules;
    }
    
    public function validate()
    {
        parent::validate();
        
        $this->validateFechasIngreso();
        
        $this->validateFechasComision();
    }
    
}
