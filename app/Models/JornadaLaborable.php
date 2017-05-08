<?php

namespace Cat\Models;

use Eloquent as Model;

/**
 * @SWG\Definition(
 *      definition="JornadaLaborable",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="fecha",
 *          description="fecha",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="id_periodo",
 *          description="id_periodo",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class JornadaLaborable extends Model
{

    public $table = 'jornadas_laborables';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'fecha',
        'id_periodo'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'fecha' => 'date',
        'id_periodo' => 'integer'
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
    public function periodo()
    {
        return $this->belongsTo(\Cat\Models\Periodo::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function presentismos()
    {
        return $this->hasMany(\Cat\Models\Presentismo::class);
    }
}
