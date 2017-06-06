<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;

class Proporcional extends Model
{

    public $table = 'proporcionales';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'mes_ingreso',
    ];
    
}
