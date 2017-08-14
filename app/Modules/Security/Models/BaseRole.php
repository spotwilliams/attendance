<?php

namespace Cat\Modules\Security\Models;

use Illuminate\Database\Eloquent\Model;

class BaseRole extends Model
{
    public $table = 'base_roles';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    
}
