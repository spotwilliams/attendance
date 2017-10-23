<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


class EstadoPeriodo extends Model
{
    
    public $table = 'estado_periodos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    protected $fillable
        = [
            'id_base',
            'id_periodo',
            'id_turno',
            'abierto',
        ];
    
    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'id_periodo');
    }
    
    public function base()
    {
        return $this->belongsTo(Base::class, 'id_base');
    }
    
    public function turno()
    {
        return $this->belongsTo(Turno::class, 'id_turno');
    }
    
    public function estaAbierto()
    {
        return $this->abierto == true;
    }
}
