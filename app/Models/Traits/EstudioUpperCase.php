<?php

namespace Cat\Models\Traits;

use Cat\Helpers\StringHelper;

trait EstudioUpperCase
{
    public function setCarreraAttribute($value)
    {
        $this->attributes['carrera'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    public function setInstitucionAttribute($value)
    {
        $this->attributes['institucion'] = strtoupper(StringHelper::removeAccents($value));
    }
    
   
}
