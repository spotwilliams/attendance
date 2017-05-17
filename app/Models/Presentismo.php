<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


class Presentismo extends Model
{

    public $table = 'presentismos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

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
        return $this->belongsTo(TipoPresentismo::class,  'id_tipo_presentismo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function jornadaLaborable()
    {
        return $this->belongsTo(JornadaLaborable::class, 'id_jornada');
    }
}
