<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 5/5/17
 * Time: 12:13
 */

namespace Cat\Modules\Validation\Rules;


use Cat\Models\TipoPresentismo;

class Presente extends Rule
{
    // No requiere validaciones
    protected function validate()
    {
        /** @var TipoPresentismo $tipoPresente */
        $tipoPresente = TipoPresentismo::find($this->tipoAusente->id);
        if ($tipoPresente === null) {
            return false;
        } else {
            return $tipoPresente->esPresente();
        }
    }
    
}