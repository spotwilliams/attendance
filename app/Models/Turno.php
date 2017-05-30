<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


class Turno extends Model
{
    
    public $table = 'turnos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    
    public $fillable
        = [
            'codigo',
            'descripcion',
        ];
}
