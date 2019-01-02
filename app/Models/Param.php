<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    public $table = 'params';
    
    const CREATED_AT   = 'created_at';
    const UPDATED_AT   = 'updated_at';
    const FECHA_CIERRE = 'fecha_cierre_periodo';
    const CANT_ACTIVOS = 'cant_agentes_activos';
    protected $dates = ['deleted_at'];
    
    public $fillable
        = [
            'param',
            'descripcion',
            'valor',
        ];
    
    
    public static function fechaCierre()
    {
        return Param::where('param', '=', self::FECHA_CIERRE)
            ->first();
    }
}
