<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 5/5/17
 * Time: 12:13
 */

namespace Cat\Modules\Validation\Rules;


class Presente extends Rule
{
    // No requiere validaciones
    protected function validate()
    {
        return true;
    }
    
}