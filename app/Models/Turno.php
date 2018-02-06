<?php

namespace Cat\Models;

use Cat\Modules\Security\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Turno extends Model
{
    use SoftDeletes;
    
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
    
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'turno_roles', 'turno_id', 'role_id');
    }
}
