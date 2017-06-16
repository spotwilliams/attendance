<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


class Turno extends Model
{
    
    public $table = 'turnos';
    
    protected $finSemana
        = [
            'FSD',
            'FSN',
        ];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    
    public $fillable
        = [
            'codigo',
            'descripcion',
        ];
    
    public function esFinDeSemana()
    {
        return in_array($this->codigo, $this->finSemana);
    }
}
