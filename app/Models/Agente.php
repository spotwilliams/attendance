<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @SWG\Definition(
 *      definition="Agente",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="nombre",
 *          description="nombre",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="apellido",
 *          description="apellido",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="dni",
 *          description="dni",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="fecha_nacimiento",
 *          description="fecha_nacimiento",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="cuit",
 *          description="cuit",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="id_base",
 *          description="id_base",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="id_area",
 *          description="id_area",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="id_domicilio",
 *          description="id_domicilio",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="id_contrato",
 *          description="id_contrato",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="id_dias_disponibles",
 *          description="id_dias_disponibles",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="id_estudio",
 *          description="id_estudio",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
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
    public function basis()
    {
        return $this->belongsTo(\Cat\Models\Basis::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function diasDisponible()
    {
        return $this->belongsTo(\Cat\Models\DiasDisponible::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function domicilio()
    {
        return $this->belongsTo(\Cat\Models\Domicilio::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function estudio()
    {
        return $this->belongsTo(\Cat\Models\Estudio::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function presentismos()
    {
        return $this->hasMany(\Cat\Models\Presentismo::class);
    }
    
    /**
     * @param TipoPresentismo $ausencia
     * @return integer
     */
    public function getCantDiasDisponibles(TipoPresentismo $ausencia)
    {
        $diasDisponibles = $this->diasDisponible()
            ->where('id_tipo_presentismo', '=', $ausencia->id)->get('cant_dias');
        
        return $diasDisponibles;
    }
}
