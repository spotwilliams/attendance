<?php

namespace Cat\Modules\Configuracion\TipoPresentismos\Requests;

use Cat\Http\Requests\Request;
use Cat\Models\Area;

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
        return Area::$rules;
    }
}
