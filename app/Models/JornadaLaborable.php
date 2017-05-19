<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;

class JornadaLaborable extends Model
{
    
    public $table = 'jornadas_laborables';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    
    protected $fillable
        = [
            'fecha',
            'id_periodo',
        ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'id_periodo');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function presentismos()
    {
        return $this->hasMany(Presentismo::class, 'id_jornada');
    }
}
