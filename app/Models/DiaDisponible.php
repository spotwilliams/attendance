<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


class DiaDisponible extends Model
{

    public $table = 'dias_disponibles';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'id_tipo_presentismo',
        'cant_dias'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'id_tipo_presentismo' => 'integer',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function tiposPresentismo()
    {
        return $this->belongsTo(\Cat\Models\TiposPresentismo::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function agentes()
    {
        return $this->hasMany(\Cat\Models\Agente::class);
    }
}
