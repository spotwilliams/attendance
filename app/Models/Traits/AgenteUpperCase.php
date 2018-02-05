<?php

namespace Cat\Models\Traits;


use Cat\Helpers\StringHelper;

trait AgenteUpperCase
{
    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    public function setApellidoAttribute($value)
    {
        $this->attributes['apellido'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    public function setDniAttribute($value)
    {
        $this->attributes['dni'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    public function setCuitAttribute($value)
    {
        $this->attributes['cuit'] = str_replace('-', '', $value);
    }
    
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    public function setObservacionAttribute($value)
    {
        $this->attributes['observacion'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    public function setProfesionAttribute($value)
    {
        $this->attributes['profesion'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    public function setEmailGobiernoAttribute($value)
    {
        $this->attributes['email_gobierno'] = strtoupper(StringHelper::removeAccents($value));
    }
}
