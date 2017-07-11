<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 6/29/17
 * Time: 11:28
 */

namespace Cat\Helpers;


use Cat\Models\Contrato;
use Cat\Models\TipoContrato;
use Illuminate\Http\Request;

class Validation
{
    public static function getDomicilioRules(Request $request)
    {
        $rules           = [
            'domicilio.constituido.0' => 'not_in:0',
            'domicilio.calle.0'       => 'required',
            'domicilio.numero.0'      => 'required|integer',
        ];
        $domiciliosInput = $request->input('domicilio');

        if (!empty($domiciliosInput['numero'][1])) {
            
            $rules['domicilio.calle.1']  = 'required';
            $rules['domicilio.numero.1'] = 'required|integer';
        }
        
        return $rules;
    }
    
    public static function getContratoRules(Request $request)
    {
        $rules = Contrato::$rules;
        if ($request->input('id_tipo_contrato') == -1) {
            return $rules;
        }
        /** @var TipoContrato $tipoContrato */
        $tipoContrato = TipoContrato::find($request->input('id_tipo_contrato'));
        
        if (!$tipoContrato->isLocacion()) {
//            unset($rules['fecha_ingreso']);
            unset($rules['tipo_inscripcion']);
        }
        
        return $rules;
    }
}