<?php

namespace Cat\Models;

use Eloquent as Model;

/**
 * @SWG\Definition(
 *      definition="Periodo",
 *      required={""},
 *      @SWG\Property(
 *          property="id_periodo",
 *          description="id_periodo",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="fecha_comienzo",
 *          description="fecha_comienzo",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="fecha_fin",
 *          description="fecha_fin",
 *          type="string",
 *          format="date"
 *      ),
 *      @SWG\Property(
 *          property="cant_dias",
 *          description="cant_dias",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class Periodo extends Model
{

    public $table = 'periodos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'fecha_comienzo',
        'fecha_fin',
        'cant_dias'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_periodo' => 'integer',
        'fecha_comienzo' => 'date',
        'fecha_fin' => 'date',
        'cant_dias' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function jornadasLaborables()
    {
        return $this->hasMany(\Cat\Models\JornadasLaborable::class);
    }
}
