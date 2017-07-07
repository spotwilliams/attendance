<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 6/29/17
 * Time: 11:28
 */

namespace Cat\Helpers;


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

        if (isset($domiciliosInput['numero'][1])) {
            
            $rules['domicilio.calle.1']  = 'required';
            $rules['domicilio.numero.1'] = 'required|integer';
        }
        
        return $rules;
    }
}