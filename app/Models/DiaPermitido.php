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
    
    public function getCantidadDias(Contrato $contrato)
    {
        if ($contrato->fin_semana === 1) {
            return $this->cant_fin_semana;
        } else {
            return $this->cant_semanal;
        }
    }
}
   
