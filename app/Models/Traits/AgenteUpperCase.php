<?php

namespace Cat\Models\Traits;


use Cat\Helpers\StringHelper;

trait AgenteUpperCase
{
    protected function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    protected function setApellidoAttribute($value)
    {
        $this->attributes['apellido'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    protected function setDniAttribute($value)
    {
        $this->attributes['dni'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    protected function setCuitAttribute($value)
    {
        $this->attributes['cuit'] = str_replace('-', '', $value);
    }
    
    protected function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    protected function setObservacionAttribute($value)
    {
        $this->attributes['observacion'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    protected function setProfesionAttribute($value)
    {
        $this->attributes['profesion'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    protected function setEmailGobiernoAttribute($value)
    {
        $this->attributes['email_gobierno'] = strtoupper(StringHelper::removeAccents($value));
    }
}
