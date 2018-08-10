<?php

namespace Cat\Models;

use Cat\Exceptions\AgenteSinTurno;
use Cat\Models\Traits\AgenteUpperCase;
use Cat\Modules\Presentismo\Exceptions\Validacion\SinTopeONoEstablecido;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Agente
 * @property Operativo $operativo
 * @package Cat\Models
 */
class Agente extends Model
{
    use SoftDeletes, AgenteUpperCase;
    
    public $table = 'agentes';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    
    public $fillable
        = [
            'nombre',
            'apellido',
            'dni',
            'fecha_nacimiento',
            'cuit',
            'telefono',
            'email',
            'estado_civil',
            'sexo',
            'id_base',
            'id_area',
            'id_domicilio',
            'id_contrato',
            'id_dias_disponibles',
            'id_estudio',
            'avatar',
            'observacion',
            'profesion',
            'email_gobierno',
            'telefono_particular',
            'telefono_casa',
            'telefono_ht',
        ];
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules
                          = [
            'nombre'              => 'required|max:255',
            'apellido'            => 'required|max:255',
            'fecha_nacimiento'    => 'required|date',
            'cuit'                => 'required|cuit|cuit_unico',
            'dni'                 => 'required|integer',
            //            'telefono'         => 'required|digits_between:1,20',
            'telefono_particular' => 'required|digits_between:1,50',
            'telefono_casa'       => 'digits_between:1,50',
            'telefono_ht'         => 'digits_between:1,50',
            'email'               => 'required|email',
            'email_gobierno'      => 'email',
        
        
        ];
    public static $avatar = 'default.jpg';
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
    
    /**
     * @return Base
     * @throws ModelNotFoundException
     **/
    public function base()
    {
        /** @var Operativo $operativo */
        $operativo = $this->operativo()->firstOrFail();
        
        return $operativo->base()->firstOrFail();
    }
    
    public function baseEloquent()
    {
        return $this->operativo->base();
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function operativo()
    {
        return $this->hasOne(Operativo::class, 'id_agente');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function contrato()
    {
        return $this->hasOne(Contrato::class, 'id_agente');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function contratoActual()
    {
        return $this->hasOne(Contrato::class, 'id_agente')
            ->orderBy('id', 'DESC')
            ->limit(1);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function contratosHistoricos()
    {
        return $this->hasMany(ContratoHistorico::class, 'id_agente');
    }
    
    /**
     * @param \DateTime $fecha
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contratoOnDate(\DateTime $fecha)
    {
        return $this->hasMany(ContratoHistorico::class, 'id_agente')
            ->whereDate('fecha_ingreso', '<=', $fecha)
            ->whereDate('fecha_fin', '>=', $fecha);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function domicilios()
    {
        return $this->hasMany(Domicilio::class, 'id_agente');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function estudio()
    {
        return $this->hasMany(Estudio::class, 'id_agente');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function presentismos()
    {
        return $this->hasMany(Presentismo::class, 'id_agente');
    }
    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function haberes()
    {
        return $this->hasMany(Haber::class, 'id_agente');
    }
    
    /**
     * @param TipoPresentismo $ausencia
     * @param \DateTime $fechaReferencia
     * @return int
     * @throws AgenteSinTurno
     * @throws SinTopeONoEstablecido
     */
    public function getCantDiasDisponibles(TipoPresentismo $ausencia, \DateTime $fechaReferencia)
    {
        /** @var Contrato $contrato */
        $contrato = $this->contrato()->first();
        
        /** @var string $mesProporcional */
        $mesProporcional = $contrato->mesIngresoProporcional($fechaReferencia);
        
        try {
            
            /** @var DiaPermitido $diasPermitidos */
            $diasPermitidos = $ausencia->diasPermitidos()
                ->where('mes_ingreso', '=', $mesProporcional)
                ->firstOrFail();
            
            try {
                
                $turno = $this->operativo()->firstOrFail()->turno()->firstOrFail();
            } catch (ModelNotFoundException $sinTurno) {
                throw new AgenteSinTurno($this);
            }
            /** @var int $cantDiasPermitidos */
            $cantDiasPermitidos = $diasPermitidos->getCantidadDias($turno);
            
            /** @var int $cantDiasConsumidos */
            $cantDiasConsumidos = $this->getCantidadDiasConsumidos($ausencia, $fechaReferencia);
            
            return $cantDiasPermitidos - $cantDiasConsumidos;
        } catch (ModelNotFoundException $diaPermitidoNoCargado) {
            return 1;
            //throw new SinTopeONoEstablecido($ausencia);
        }
    }
    
    
    public function getCantidadDiasConsumidos(TipoPresentismo $tipoPresentismo, \DateTime $fechaReferencia)
    {
        $dias = $this->presentismos()
            ->where('id_tipo_presentismo', '=', $tipoPresentismo->id)
            ->where('injustificado', '=', false)
            ->whereDate('fecha', '>=', $fechaReferencia->format('Y-01-01'))
            // Verifico que en el presente year no tenga consumido los dias
            ->whereDate('fecha', '<=', $fechaReferencia->format('Y-12-31'))
            ->count();
        
        return $dias;
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function facturas()
    {
        return $this->hasMany(FacturaFisica::class, 'id_agente');
    }
    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function facturasByPeriodo(Periodo $periodo)
    {
        return $this->hasMany(FacturaFisica::class, 'id_agente')
            ->where('id_periodo', '=', $periodo->id);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'id_agente');
    }
}
