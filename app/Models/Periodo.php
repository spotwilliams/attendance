<?php

namespace Cat\Models;

use Cat\Modules\Presentismo\Exceptions\Validacion\BaseTurnoSinPeriodo;
use Cat\Modules\Presentismo\Exceptions\Validacion\PeriodoAbierto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class Periodo
 * @property string fecha_comienzo
 * @property string fecha_fin
 * @package Cat\Models
 */
class Periodo extends Model
{
    
    public $table = 'periodos';
    
    const CREATED_AT        = 'created_at';
    const UPDATED_AT        = 'updated_at';
    const CANT_DIAS_DEFAULT = 30;
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
    
    public function haberes()
    {
        return $this->hasMany(Haber::class, 'id_periodo');
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
        
        /** @var Periodo $periodoActual */
        $periodoActual = Periodo::whereDate('fecha_comienzo', '<=', $fecha)
            ->whereDate('fecha_fin', '>=', $fecha)
            ->first();
        
        return $periodoActual;
    }
    
    /**
     * @param Base $base
     * @param Turno $turno
     * @return bool
     * @throws BaseTurnoSinPeriodo
     */
    public function estaActivo(Base $base, Turno $turno)
    {
        try {
            $estado = $this->estados()
                ->where('id_base', '=', $base->id)
                ->where('id_turno', '=', $turno->id)
                ->firstOrFail();
            
            return ($estado->abierto == true);
            
        } catch (ModelNotFoundException $e) {
            throw new BaseTurnoSinPeriodo($this, $base, $turno);
//            return false;
        }
        
    }
    
    public static function getUltimoPeriodo()
    {
        $previo = Periodo::orderBy('fecha_fin', 'DESC')->first();
        if ($previo === null) {
            // En caso que el periodo previo no exista se simula uno
            // a partir del 16 de presente mes
            $fecha = new \DateTime('now');
            // El periodo anterior cerro ayer
            $fecha->modify('-1day');
            $fin = $fecha->format('Y-m-d');
            
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
    
    
    public function bases()
    {
        return $this->belongsToMany(Base::class, 'estado_periodos', 'id_periodo', 'id_base')->withPivot(['abierto']);
    }
    
    /**
     * Verifica si la fecha que recibo esta en el periodo
     *
     * @param \DateTime $date
     * @return bool
     */
    public function fechaComprendida(\DateTime $date)
    {
        $desde = new \DateTime($this->fecha_comienzo);
        $hasta = new \DateTime($this->fecha_fin);
        $date->setTime(0, 0, 0);
        if (($desde <= $date) and ($date <= $hasta)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Verifica si se pueden calcular los montos tomando como referencia una fecha particular
     * @throws PeriodoAbierto
     * @return true
     */
    public function validarSiPuedeCalcular()
    {
        if ($this->fechaComprendida(new \DateTime('now'))) {
            throw new PeriodoAbierto($this);
        } else {
            return true;
        }
    }
    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function facturas()
    {
        return $this->hasMany(FacturaFisica::class, 'id_periodo');
    }
}
