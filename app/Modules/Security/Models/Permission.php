<?php

namespace Cat\Modules\Security\Models;

use Cat\Modules\Security\Panel\Traits\CrudTrait;
use Spatie\Permission\Models\Permission as OriginalPermission;

class Permission extends OriginalPermission
{
    use CrudTrait;

    protected $fillable = ['name', 'comentarios', 'updated_at', 'created_at'];
}
