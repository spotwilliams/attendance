<?php

namespace Cat\Models;

use Cat\EstadoPeriodo;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    
    public $table = 'periodos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function jornadasLaborables()
    {
        return $this->hasMany(JornadaLaborable::class, 'id_periodo');
    }
    
    
    public function estados()
    {
        return $this->hasMany(EstadoPeriodo::class, 'id_periodo');
    }
    
    /**
     * @param \DateTime|null $fecha
     */
    public static function findActivo(\DateTime $fecha = null)
    {
        if ($fecha == null) {
            $fecha = new \DateTime('now');
        }
        $fecha = $fecha->format('Y-m-d');
        
        /** @var Periodo $periodoActual */
        $periodoActual = Periodo::where('fecha_comienzo', '<=', $fecha)
            ->where('fecha_fin', '>=', $fecha)->first();
        
        return $periodoActual;
    }
}
