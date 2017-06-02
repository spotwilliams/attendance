<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


class Agente extends Model
{
    
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
    
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules
        = [
            'nombre'           => 'required|max:255',
            'apellido'         => 'required|max:255',
            'fecha_nacimiento' => 'required',
            'cuit'             => 'required',
            'dni'              => 'required',
            'telefono'         => 'required',
            'email'            => 'required|email',
        
        
        ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function area()
    {
        return $this->belongsTo(\Cat\Models\Area::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function base()
    {
        /** @var Operativo $operativo */
        $operativo = $this->operativo()->first();
        
        return $operativo->base()->first();
    }
    
    public function operativo()
    {
        return $this->hasOne(Operativo::class, 'id_agente');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function contrato()
    {
        return $this->hasOne(Contrato::class, 'id_agente')->first();
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function diasDisponible()
    {
        return $this->hasMany(DiaDisponible::class, 'id_agente');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function domicilios()
    {
        return $this->hasMany(Domicilio::class, 'id_agente');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
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
     * @param TipoPresentismo $ausencia
     * @return integer
     */
    public function getCantDiasDisponibles(TipoPresentismo $ausencia)
    {
        $diasDisponibles = $this
            ->diasDisponible()
            ->where('id_tipo_presentismo', '=', $ausencia->id)->first(['cant_dias']);
        
        return $diasDisponibles->cant_dias;
    }
}
