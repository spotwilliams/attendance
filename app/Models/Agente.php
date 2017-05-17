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
    protected $casts
        = [
            'id'                  => 'integer',
            'nombre'              => 'string',
            'apellido'            => 'string',
            'dni'                 => 'integer',
            'fecha_nacimiento'    => 'date',
            'cuit'                => 'string',
            'id_base'             => 'integer',
            'id_area'             => 'integer',
            'id_domicilio'        => 'integer',
            'id_contrato'         => 'integer',
            'id_dias_disponibles' => 'integer',
            'id_estudio'          => 'integer',
        ];
    
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules
        = [
        
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
    public function bases()
    {
        return $this->belongsTo(Base::class);
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
