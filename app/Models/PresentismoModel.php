<?php

namespace Cat\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="PresentismoModel",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="id_agente",
 *          description="id_agente",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="id_jornada",
 *          description="id_jornada",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="id_tipo_presentismo",
 *          description="id_tipo_presentismo",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class PresentismoModel extends Model
{
    use SoftDeletes;

    public $table = 'presentismos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'id_agente',
        'id_jornada',
        'id_tipo_presentismo'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'id_agente' => 'integer',
        'id_jornada' => 'integer',
        'id_tipo_presentismo' => 'integer'
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
    public function agente()
    {
        return $this->belongsTo(\Cat\Models\Agente::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function tiposPresentismo()
    {
        return $this->belongsTo(\Cat\Models\TiposPresentismo::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function jornadasLaborable()
    {
        return $this->belongsTo(\Cat\Models\JornadasLaborable::class);
    }
}
