<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


class Funcion extends Model
{
    
    public $table = 'funciones';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    
    public $fillable
        = [
            'nombre',
            'id_funcion_padre',
        ];
}
