<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{

    public $table = 'areas';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'nombre',
    ];

    

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function agentes()
    {
        return $this->hasMany(Agente::class, 'id_area');
    }
}
