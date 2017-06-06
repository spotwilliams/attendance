<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


class DiaPermitido extends Model
{
    
    public $table = 'dias_permitidos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    protected $fillable
        = [
            'cant_semanal',
            'cant_fin_semana',
            'id_tipo_presentimos',
            'id_proporcional',
            'corridos',
        ];
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules
        = [
        
        ];
    
    public function getCantidadDias(\DateTime $fecha)
    {
        if ($fecha->format('N') >= 6) {
            return $this->cant_semanal;
        } else {
            return $this->cant_fin_semana;
        }
    }
}
   
