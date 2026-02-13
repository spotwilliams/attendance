<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Horario
 * @package Cat\Models
 *
 * @property string hora_entrada
 * @property string hora_salida
 */
class Horario extends Model
{
    use HasFactory;

    public $table = 'horarios';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    
    public $fillable
        = [
            'hora_entrada',
            'hora_salida',
            'eximido',
            'rotativo',
        ];
}
