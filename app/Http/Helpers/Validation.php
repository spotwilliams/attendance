<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 6/29/17
 * Time: 11:28
 */

namespace Cat\Helpers;


use Cat\Models\Contrato;
use Cat\Models\EstadoContrato;
use Cat\Models\TipoContrato;
use Illuminate\Http\Request;

class Validation
{
    public static function getDomicilioRules(Request $request)
    {
        $rules           = [
            'domicilio.constituido.0'   => 'not_in:0',
            'domicilio.calle.0'         => 'required',
            'domicilio.numero.0'        => 'required|integer',
            'domicilio.codigo_postal.0' => 'integer',
        ];
        $domiciliosInput = $request->input('domicilio');
        
        if (!empty($domiciliosInput['numero'][1])) {
            
            $rules['domicilio.calle.1']         = 'required';
            $rules['domicilio.numero.1']        = 'required|integer';
            $rules['domicilio.codigo_postal.1'] = 'integer';
        }
        
        return $rules;
    }
    
    public static function getContratoRules(Request $request)
    {
        $rules = Contrato::$rules;
        
        /**
         *
         * Por el tipo de contrato
         *
         */
        if ($request->input('id_tipo_contrato') == -1) {
            return $rules;
        }
        /** @var TipoContrato $tipoContrato */
        $tipoContrato = TipoContrato::find($request->input('id_tipo_contrato'));
        
        if (!$tipoContrato->isLocacion()) {
            unset($rules['tipo_inscripcion']);
        }
        /**
         *
         * Por el estado de contrato
         *
         */
        if ($request->input('id_estado_contrato') == -1) {
            return $rules;
        }
        /** @var EstadoContrato $estadoContrato */
        $estadoContrato = EstadoContrato::find($request->input('id_estado_contrato'));
        if ($estadoContrato->esActivo()) {
            unset($rules['fecha_baja']);
        }
        
        return $rules;
    }
}