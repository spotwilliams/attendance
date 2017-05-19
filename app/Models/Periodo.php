<?php

namespace Cat\Models;

use Cat\EstadoPeriodo;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    
    public $table = 'periodos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    protected $fillable
        = [
            'fecha_comienzo',
            'fecha_fin',
            'cant_dias',
        ];
    
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
     * @return Periodo
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
    
    /**
     * @param $idBase
     * @return bool
     */
    public function estaActivo($idBase)
    {
        $estado = $this->estados()->where('id_base', '=', $idBase)->first();

        if ($estado === null) {
            return false;
        } else {
            return ($estado->abierto === 1);
        }
    }
}
