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
        $rules      = [
            'domicilio.constituido.0' => 'not_in:0',
        ];
        $rulesGroup = ['calle', 'numero'];
        foreach ($request->input('domicilio') as $key => $value) {
            if (in_array($key, $rulesGroup)) {
                foreach ($value as $index => $val) {
                    $rules["domicilio.calle.$index"]  = 'required';
                    $rules["domicilio.numero.$index"] = 'required|integer';
                }
            }
            
            
        }
        
        return $rules;
    }
}