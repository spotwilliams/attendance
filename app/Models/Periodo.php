<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    
    public $table = 'periodos';
    
    const CREATED_AT        = 'created_at';
    const UPDATED_AT        = 'updated_at';
    const CANT_DIAS_DEFAULT = 15;
    protected $fillable
        = [
            'fecha_comienzo',
            'fecha_fin',
            'cant_dias',
        ];
    
    
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
    public function estaActivo(Base $base)
    {
        $estado = $this->estados()->where('id_base', '=', $base->id)->first();
        
        if ($estado === null) {
            return false;
        } else {
            return ($estado->abierto === 1);
        }
    }
    
    public static function getUltimoPeriodo()
    {
        $previo = Periodo::orderBy('fecha_fin', 'DESC')->first();
        if ($previo === null) {
            // En caso que el periodo previo no exista se simula uno
            $fecha  = new \DateTime('now');
            // El periodo anterior cerro ayer
            $fecha->modify('-1day');
            $fin    = $fecha->format('Y-m-d');
    
            // El periodo anterior duro 15 dias
            $fecha->modify('-' . self::CANT_DIAS_DEFAULT . 'day');
            $inicio = $fecha->format('Y-m-d');
    
            $previo = new Periodo([
                'id'             => -1,
                'fecha_comienzo' => $inicio,
                'fecha_fin'      => $fin,
                'cant_dias'      => self::CANT_DIAS_DEFAULT,
            ]);
        }
        
        return $previo;
    }
}
