<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @SWG\Definition(
 *      definition="Contrato",
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
class Contrato extends Model
{
    public const TIPO_LOCACION = 'LOCACION';
    
    public $table = 'contratos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    public $fillable
        = [
            'tipo_contrato',
            'fecha_firma',
            'fecha_comienzo',
            'id_estado_contrato',
        ];
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts
        = [
            'id'                 => 'integer',
            'tipo_contrato'      => 'string',
            'fecha_firma'        => 'date',
            'fecha_comienzo'     => 'date',
            'id_estado_contrato' => 'integer',
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
    public function estadoContrato()
    {
        return $this->belongsTo(EstadoContrato::class, 'id_estado_contrato');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function tipoContrato()
    {
        return $this->belongsTo(TipoContrato::class, 'id_tipo_contrato');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function agentes()
    {
        return $this->belongsTo(Agente::class, 'id_agente');
    }
    
    
    /**
     * True si es del tipo Locacion de servicios
     * @return bool
     */
    public function esLocacion()
    {
        if (strtolower($this->tipo_contrato) === strtolower(Contrato::TIPO_LOCACION)) {
            return true;
        } else {
            return false;
        }
    }
}
