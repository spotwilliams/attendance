<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Funcion extends Model
{
    use HasFactory;

    public $table = 'funciones';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    
    public $fillable
        = [
            'nombre',
            'id_padre',
        ];
    
    
    public function hijas()
    {
        return $this->hasMany(Funcion::class, 'id_padre', 'id');
    }
    
    public function padre()
    {
        return $this->belongsTo(Funcion::class, 'id_padre', 'id');
    }
}
