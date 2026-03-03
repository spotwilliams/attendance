<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


class Notificacion extends Model
{
    
    public $table = 'notificaciones';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const REGULAR    = 'REGULAR';
    const LIBRE      = 'LIBRE';
    
    public $fillable
        = [
            'id_agente',
            'id_periodo',
            'tipo',
            'fecha_factura',
            'fecha_pago',
            'mensaje',
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
    public function agente()
    {
        return $this->belongsTo(Agente::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }
    /**
     * The attributes that should be casted to native types.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
            'id'            => 'integer',
            'id_agente'     => 'integer',
            'id_periodo'    => 'integer',
            'tipo'          => 'string',
            'fecha_factura' => 'string',
            'fecha_pago'    => 'string',
            'mensaje'       => 'string',
        ];
    }
}
