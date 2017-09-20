<?php

namespace Cat\Models;

use Cat\User;
use Illuminate\Database\Eloquent\Model;


class Presentismo extends Model
{
    
    public $table = 'presentismos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    protected $fillable
        = [
            'id_agente',
            'id_periodo',
            'fecha',
            'id_tipo_presentismo',
            'injustificado',
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
    public function tipoPresentismo()
    {
        return $this->belongsTo(TipoPresentismo::class, 'id_tipo_presentismo');
    }
    
    public function periodo()
    {
        return $this->belongsTo(Presentismo::class, 'id_periodo');
        
    }
    
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_presentismo');
    }
}
