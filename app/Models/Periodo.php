<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{

    public $table = 'periodos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function jornadasLaborables()
    {
        return $this->hasMany(JornadaLaborable::class, 'id_periodo');
    }
}
