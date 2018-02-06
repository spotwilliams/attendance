<?php

namespace Cat\Http\Requests;

use Carbon\Carbon;
use Cat\Helpers\Validation;

class LaboralesRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Validation::getContratoRules($this);
    }
    
    public function validate()
    {
        parent::validate();
        
        $ingresoGobierno = Carbon::createFromFormat(
            'Y-m-d',
            (new \DateTime($this->input('fecha_ingreso_gobierno')))->format('Y-m-d')
        );
        
        $fechaContrato = Carbon::createFromFormat(
            'Y-m-d',
            (new \DateTime($this->input('fecha_ingreso')))->format('Y-m-d')
        );
        
        if ($ingresoGobierno->gt($fechaContrato)) {
            // No puede ingresar al gobierno despues del contrato
            /** @var  $validator */
            $validator = $this->getValidatorInstance();
            
            $validator->getMessageBag()
                ->add('fecha_ingreso_gobierno', 'La fecha de ingreso al GCBA debe ser anterior a la fecha de contrato.');
            
            $this->failedValidation($validator);
        } else {
            return true;
        }
        
        
    }
}
