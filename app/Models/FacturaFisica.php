<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Agente $agente
 */
class FacturaFisica extends Model
{
    
    public $table = 'facturas_fisicas';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    
    public $fillable
        = [
            'id_agente',
            'id_periodo',
            'nro_factura',
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
            'id'          => 'integer',
            'id_agente'   => 'integer',
            'id_periodo'  => 'integer',
            'nro_factura' => 'string',
        ];
    }
}
