<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use HasFactory;
    use SoftDeletes;
    
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
    
    public function operativos()
    {
        return $this->hasMany(Operativo::class, 'id_area');
        
    }
}
