<?php

namespace Cat\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="AreasModel",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="direccion",
 *          description="direccion",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="gerencia",
 *          description="gerencia",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="subgerencia",
 *          description="subgerencia",
 *          type="string"
 *      )
 * )
 */
class AreasModel extends Model
{
    use SoftDeletes;

    public $table = 'areas';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'direccion',
        'gerencia',
        'subgerencia'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'direccion' => 'string',
        'gerencia' => 'string',
        'subgerencia' => 'string'
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
    public function agentes()
    {
        return $this->hasMany(\Cat\Models\Agente::class);
    }
}
