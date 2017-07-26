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
            'FSI',
        ];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    
    public        $fillable
        = [
            'codigo',
            'descripcion',
        ];
    public static $rules
        = [
            'codigo'      => 'required',
            'descripcion' => 'required',
        ];
    
    public function esFinDeSemana()
    {
        return in_array($this->codigo, $this->finSemana);
    }
}
