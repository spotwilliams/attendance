<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


class Horario extends Model
{
    
    public $table = 'horarios';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    
    public $fillable
        = [
            'hora_entrada',
            'hora_salida',
        ];
}
