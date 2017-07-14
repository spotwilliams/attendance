<?php

namespace Cat\Models;

use Cat\Modules\Presentismo\Exceptions\Validacion\SinTopeONoEstablecido;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;


class Agente extends Model
{
    use SoftDeletes;
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
            'nombre'           => 'required|max:255',
            'apellido'         => 'required|max:255',
            'fecha_nacimiento' => 'required|date',
            'cuit'             => 'required|integer',
            'dni'              => 'required|integer',
            'telefono'         => 'required|digits_between:1,20',
            'email'            => 'required|email',
        
        
        ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
    
    /**
     * @return Base
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
     * @return int
     * @throws SinTopeONoEstablecido
     */
    public function getCantDiasDisponibles(TipoPresentismo $ausencia)
    {
        /** @var Contrato $contrato */
        $contrato = $this->contrato()->first();
        
        /** @var string $mesProporcional */
        $mesProporcional = $contrato->mesIngresoProporcional();
        
        try {
            
            /** @var DiaPermitido $diasPermitidos */
            $diasPermitidos = $ausencia->diasPermitidos()
                ->where('mes_ingreso', '=', $mesProporcional)
                ->firstOrFail();
            
            /**  */
            $turno = $this->operativo()->first()->turno()->first();
            /** @var int $cantDiasPermitidos */
            $cantDiasPermitidos = $diasPermitidos->getCantidadDias($turno);

            /** @var int $cantDiasConsumidos */
            $cantDiasConsumidos = $this->getCantidadDiasConsumidos($ausencia);
            
            return $cantDiasPermitidos - $cantDiasConsumidos;
        } catch (ModelNotFoundException $diaPermitidoNoCargado) {
            return 1;
            throw new SinTopeONoEstablecido($ausencia);
        }
    }
    
    
    public function getCantidadDiasConsumidos(TipoPresentismo $tipoPresentismo)
    {
        $dias = $this->presentismos()
            ->where('id_tipo_presentismo', '=', $tipoPresentismo->id)
            ->where('injustificado', '=', 0)
            ->whereDate('created_at', '>=', date('Y-01-01'))
            ->whereDate('created_at', '<=', date('Y-m-d'))
            ->count();
        
        return $dias;
    }
}
