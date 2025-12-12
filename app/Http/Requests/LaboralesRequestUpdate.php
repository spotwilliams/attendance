<?php

namespace Cat\Http\Requests;

use Cat\Helpers\PermisoEspecialChecker;
use Cat\Helpers\Validation;
use Cat\Models\Agente;

class LaboralesRequestUpdate extends LaboralesRequest
{
    protected $permisoEspecial = 'Cargar contratos pasados';
    
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
        if (($agente !== null) and ($agente->contrato) and ($agente->contrato->fecha_ingreso === $this->input('fecha_ingreso'))) {
            $rules['fecha_ingreso'] = 'required|date|fecha_contrato_futuro';
        } else {
            // Si tengo un permiso especial, entonces no necesito usar esta validacion
            $fechaContratoRule = PermisoEspecialChecker::check($this->permisoEspecial) ? '' : '|fecha_contrato';
            $rules['fecha_ingreso'] = 'required|date|fecha_contrato_futuro' . $fechaContratoRule;
        }
        
        return $rules;
    }
    
    public function validateResolved()
    {
        parent::validate();
        
        $this->validateFechasIngreso();
        
        $this->validateFechasComision();
    }
    
}
