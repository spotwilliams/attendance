<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;



class TipoContrato extends Model
{
    
    public $table = 'tipo_contratos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    public function contratos()
    {
        $this->hasMany(Contrato::class, 'id_tipo_contrato');
    }
}
