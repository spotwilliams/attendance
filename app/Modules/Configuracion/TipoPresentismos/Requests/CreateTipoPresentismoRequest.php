<?php

namespace Cat\Modules\Configuracion\TipoPresentismos\Requests;

use Cat\Http\Requests\Request;
use Cat\Models\Area;
use Cat\Models\TipoPresentismo;

class CreateTipoPresentismoRequest extends Request
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
        $rules = [
            'codigo'      => 'required',
            'descripcion' => 'required',
            'color'       => 'required',
            'color_letra' => 'required',
        ];
        
        if ($this->input('tiene_tope') == '1') {
            $rules['cant_semanal'] = 'required|integer|min:1';
            $rules['cant_fin_semana'] = 'required|integer|min:1';
        }
        
        return $rules;
    }
}
