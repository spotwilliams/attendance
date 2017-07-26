<?php

namespace Cat\Modules\Configuracion\Turnos\Requests;

use Cat\Http\Requests\Request;
use Cat\Models\Turno;

class CreateTurnoModelRequest extends Request
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
        return Turno::$rules;
    }
}
