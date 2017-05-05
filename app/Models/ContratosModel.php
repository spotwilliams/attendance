<?php

namespace Cat\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="ContratosModel",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="tipo_contrato",
 *          description="tipo_contrato",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="fecha_firma",
 *          description="fecha_firma",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="fecha_comienzo",
 *          description="fecha_comienzo",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="id_estado_contrato",
 *          description="id_estado_contrato",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class ContratosModel extends Model
{
    use SoftDeletes;

    public $table = 'contratos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'tipo_contrato',
        'fecha_firma',
        'fecha_comienzo',
        'id_estado_contrato'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'tipo_contrato' => 'string',
        'fecha_firma' => 'date',
        'fecha_comienzo' => 'date',
        'id_estado_contrato' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function estadoContrato()
    {
        return $this->belongsTo(\Cat\Models\EstadoContrato::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function agentes()
    {
        return $this->hasMany(\Cat\Models\Agente::class);
    }
}
