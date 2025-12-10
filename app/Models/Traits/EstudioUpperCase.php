<?php

namespace Cat\Models\Traits;

use Cat\Helpers\StringHelper;

trait EstudioUpperCase
{
    protected function setCarreraAttribute($value)
    {
        $this->attributes['carrera'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    protected function setInstitucionAttribute($value)
    {
        $this->attributes['institucion'] = strtoupper(StringHelper::removeAccents($value));
    }
    
   
}
