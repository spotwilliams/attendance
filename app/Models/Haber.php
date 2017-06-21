<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


class Haber extends Model
{
    
    public $table = 'haberes';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    protected $fillable
        = [
            'id_agente',
            'id_periodo',
            'id_base',
            'id_turno',
            'monto_facturado',
            'monto_contrato',
        ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function agente()
    {
        return $this->belongsTo(Agente::class, 'id_agente');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'id_periodo');
    }
    
}
