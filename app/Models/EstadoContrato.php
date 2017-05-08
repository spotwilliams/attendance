<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @SWG\Definition(
 *      definition="EstadoContrato",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="estado",
 *          description="estado",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="descripcion",
 *          description="descripcion",
 *          type="string",
 *      ),
 *      @SWG\Property(
 *          property="id_padre",
 *          description="id_padre",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class EstadoContrato extends Model
{
    
    const ESTADO_ACTIVO = 'ACTIVO';
    public $table = 'estado_contratos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    
    public $fillable
        = [
            'estado',
            'descripcion',
        ];
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts
        = [
            'id_padre' => 'integer',
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function contratos()
    {
        return $this->hasMany(Contrato::class);
    }
    
    public function estadoPadreActivo()
    {
        return EstadoContrato::where('estado', EstadoContrato::ESTADO_ACTIVO)->first();
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function padre()
    {
        return $this->belongsTo(EstadoContrato::class, 'id_padre');
    }
    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function hijos()
    {
        return $this->hasMany(EstadoContrato::class, 'id_padre');
    }
    
    public function esActivo()
    {
        // Verificar que sea el estado padre activo
        if (strtolower($this->estado) === strtolower(EstadoContrato::ESTADO_ACTIVO)) {
            return true;
        } else {
            // Verificar que sea hijo de activoalguno de sus hijos.
            $padre             = $this->padre();
            $padreEstadoActivo = $this->estadoPadreActivo();
            
            if ($padre->id === $padreEstadoActivo->id) {
                return true;
            } else {
                return false;
            }
        }
    }
}
