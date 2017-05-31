<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


class Operativo extends Model
{
    
    public $table = 'operativos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    
    public $fillable
        = [
            'id_agente',
            'id_base',
            'id_area',
            'id_turno',
            'id_horario',
            'id_funcion',
        ];
    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function area()
    {
        return $this->belongsTo(\Cat\Models\Area::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function bases()
    {
        return $this->belongsTo(Base::class);
    }
    
}
