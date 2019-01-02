<?php

namespace Cat\Models\Traits;

use Cat\Helpers\StringHelper;

trait DomicilioUpperCase
{
    public function setCodigoPostalAttribute($value)
    {
        $this->attributes['codigo_postal'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    public function setCalleAttribute($value)
    {
        $this->attributes['calle'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    public function setNumeroAttribute($value)
    {
        $this->attributes['numero'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    public function setDeptartamentoAttribute($value)
    {
        $this->attributes['deptartamento'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    public function setPisoAttribute($value)
    {
        $this->attributes['piso'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    public function setBarrioAttribute($value)
    {
        $this->attributes['barrio'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    public function setProvinciaAttribute($value)
    {
        $this->attributes['provincia'] = strtoupper(StringHelper::removeAccents($value));
    }
    
    public function setLibreAttribute($value)
    {
        $this->attributes['libre'] = strtoupper(StringHelper::removeAccents($value));
    }
}
