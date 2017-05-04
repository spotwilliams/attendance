<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="DomicilioModel",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="calle",
 *          description="calle",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="numero",
 *          description="numero",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="deptartamento",
 *          description="deptartamento",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="piso",
 *          description="piso",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="barrio",
 *          description="barrio",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="provincia",
 *          description="provincia",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="libre",
 *          description="libre",
 *          type="string"
 *      )
 * )
 */
class DomicilioModel extends Model
{
    use SoftDeletes;

    public $table = 'domicilios';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'calle',
        'numero',
        'deptartamento',
        'piso',
        'barrio',
        'provincia',
        'libre'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'calle' => 'string',
        'numero' => 'string',
        'deptartamento' => 'string',
        'piso' => 'string',
        'barrio' => 'string',
        'provincia' => 'string',
        'libre' => 'string'
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
        return $this->hasMany(\App\Models\Agente::class);
    }
}
