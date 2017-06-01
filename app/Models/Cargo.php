<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    
    public $table = 'cargos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    public $fillable
        = [
            'nombre',
        ];
    
}
