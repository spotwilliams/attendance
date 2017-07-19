<?php

namespace Cat\Security\Models;

use Cat\Security\Panel\Traits\CrudTrait;
use Spatie\Permission\Models\Permission as OriginalPermission;

class Permission extends OriginalPermission
{
    use CrudTrait;

    protected $fillable = ['name', 'updated_at', 'created_at'];
}
