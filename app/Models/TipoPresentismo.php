<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


class TipoPresentismo extends Model
{
    
    protected $table = 'tipos_presentismos';
    
    const CREATED_AT    = 'created_at';
    const UPDATED_AT    = 'updated_at';
    const INJUSTIFICADO = 'INJUSTIFICADO';
    
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts
        = [
            'id'              => 'integer',
            'dias_permitidos' => 'integer',
            'id_padre'        => 'integer',
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
    public function presentismos()
    {
        return $this->hasMany(Presentismo::class, 'id_tipo_presentismo', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function padre()
    {
        return $this->belongsTo(TipoPresentismo::class, 'id_padre');
    }
    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function hijos()
    {
        return $this->hasMany(TipoPresentismo::class, 'id_padre');
    }
    
    
    public function diasDisponibles()
    {
        return $this->hasMany(DiaDisponible::class, 'id_tipo_presentismo');
    }
}