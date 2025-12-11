<?php

namespace Cat\Models\Traits;

use Cat\Helpers\StringHelper;

trait DomicilioUpperCase
{
    protected function setCodigoPostalAttribute($value)
    {
        $this->attributes['codigo_postal'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    protected function setCalleAttribute($value)
    {
        $this->attributes['calle'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    protected function setNumeroAttribute($value)
    {
        $this->attributes['numero'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    protected function setDeptartamentoAttribute($value)
    {
        $this->attributes['deptartamento'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    protected function setPisoAttribute($value)
    {
        $this->attributes['piso'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    protected function setBarrioAttribute($value)
    {
        $this->attributes['barrio'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    protected function setProvinciaAttribute($value)
    {
        $this->attributes['provincia'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    protected function setLibreAttribute($value)
    {
        $this->attributes['libre'] = strtoupper(StringHelper::removeAccents($value));
    }
}
