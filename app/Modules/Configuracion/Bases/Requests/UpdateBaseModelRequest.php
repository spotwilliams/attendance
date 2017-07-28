<?php

namespace Cat\Modules\Configuracion\Bases\Requests;

use Cat\Http\Requests\Request;
use Cat\Models\Base;

class UpdateBaseModelRequest extends Request
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
        return Base::$rules;
    }
}
