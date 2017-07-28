<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    
    public $table = 'areas';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    
    public $fillable
        = [
            'nombre',
        ];
    
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules
        = [
            'nombre' => 'required',
        ];
}
