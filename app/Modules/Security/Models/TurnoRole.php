<?php

namespace Cat\Modules\Security\Models;

use Illuminate\Database\Eloquent\Model;

class TurnoRole extends Model
{
    public $table = 'turno_roles';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    
}
