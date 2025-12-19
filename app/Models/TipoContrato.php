<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


class TipoContrato extends Model
{
    use HasFactory;
    
    public $table = 'tipo_contratos';
    
    const CREATED_AT             = 'created_at';
    const UPDATED_AT             = 'updated_at';
    const TIPO_SITUACION_REVISTA = 'SITUACION_REVISTA';
    const TIPO_LOCACION          = 'LOCACION';
    public $notFoundMessage = 'El tipo de contrato especificado es incorrecto.';
    
    public function contratos()
    {
        $this->hasMany(Contrato::class, 'id_tipo_contrato');
    }
    
    /**
     * @return Collection
     */
    public static function getEquivalentesLocacion()
    {
        return TipoContrato::where('codigo', '=', self::TIPO_LOCACION)->get();
    }
    
    public function isLocacion()
    {
        return $this->codigo == self::TIPO_LOCACION;
    }
}
