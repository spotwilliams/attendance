<?php

namespace Cat\Http\Requests;

use Carbon\Carbon;
use Cat\Helpers\Validation;
use Cat\Models\EstadoContrato;

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
        
        $this->validateFechasIngreso();
        
        $this->validateFechasComision();
    }
    
    protected function validateFechasIngreso()
    {
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
                ->add('fecha_ingreso_gobierno',
                    'La fecha de ingreso al GCBA debe ser anterior a la fecha de contrato.');
            
            $this->failedValidation($validator);
        } else {
            return true;
        }
        
        return true;
    }
    
    protected function validateFechasComision()
    {
        /** @var  $validator */
        $validator = $this->getValidatorInstance();
        if (EstadoContrato::comision()->id === EstadoContrato::find($this->input('id_estado_contrato'))->id) {
            
            $desde = $fechaContrato = Carbon::createFromFormat(
                'Y-m-d',
                (new \DateTime($this->input('fecha_estado_desde')))->format('Y-m-d')
            );
            
            $hasta = $fechaContrato = Carbon::createFromFormat(
                'Y-m-d',
                (new \DateTime($this->input('fecha_estado_hasta')))->format('Y-m-d')
            );
            
            if ($hasta->lt($desde)) {
                $validator->getMessageBag()
                    ->add('fecha_estado_hasta',
                        'La fecha hasta no puede ser menor a la desde.');
                
                $this->failedValidation($validator);
            }
            
            $fIngreso = Carbon::createFromFormat('Y-m-d', $this->input('fecha_ingreso'));
            $fFin     = Carbon::createFromFormat('Y-m-d', $this->input('fecha_fin'));
            
            
            if (!$desde->between($fIngreso, $fFin)) {
                $validator->getMessageBag()
                    ->add('fecha_estado_desde',
                        'La fecha debe ser mayor a la fecha de ingreso de la modaldiad actual y menor a la fecha de fin en caso de existir');
                $this->failedValidation($validator);
            } elseif (!$hasta->between($fIngreso, $fFin)) {
                $validator->getMessageBag()
                    ->add('fecha_estado_hasta',
                        'La fecha debe ser mayor a la fecha de ingreso de la modaldiad actual y menor a la fecha de fin en caso de existir');
                $this->failedValidation($validator);
                
            }
        }
    }
    
}
