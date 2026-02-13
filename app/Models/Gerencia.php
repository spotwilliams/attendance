<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gerencia extends Model
{
    use HasFactory;

    public $table = 'gerencias';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    public $fillable
        = [
            'nombre',
            'id_padre',
        ];
    public function hijas()
    {
        return $this->hasMany(Gerencia::class, 'id_padre', 'id');
    }
    
    public function padre()
    {
        return $this->belongsTo(Gerencia::class, 'id_padre', 'id');
    
    }
}
