<?php

namespace Cat\Security\Controllers;

use Cat\Security\Controllers\Crud\CrudController;
// VALIDATION
use Cat\Security\Models\Permission;
use Cat\Security\Models\Role;
use Cat\Security\Requests\PermissionCrudRequest as StoreRequest;
use Cat\Security\Requests\PermissionCrudRequest as UpdateRequest;
use Cat\User;

class PermissionCrudController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel(Permission::class);
        $this->crud->setEntityNameStrings('Permiso', 'Permisos');
        $this->crud->setRoute('seguridad/permission');

        $this->crud->addColumn([
            'name'  => 'name',
            'label' => 'Nombre Rol',
            'type'  => 'text',
        ]);
//        $this->crud->addColumn([ // n-n relationship (with pivot table)
//            'label'     => 'Nombre Rol',
//            'type'      => 'select_multiple',
//            'name'      => 'roles',
//            'entity'    => 'roles',
//            'attribute' => 'name',
//            'model'     => Role::class,
//            'pivot'     => true,
//        ]);

        $this->crud->addField([
            'name'  => 'name',
            'label' => 'Nombre Rol',
            'type'  => 'text',
        ]);
//        $this->crud->addField([
//            'label'     => 'Roles',
//            'type'      => 'checklist',
//            'name'      => 'roles',
//            'entity'    => 'roles',
//            'attribute' => 'name',
//            'model'     => Role::class,
//            'pivot'     => true,
//        ]);

        if (!config('backpack.permissionmanager.allow_permission_create')) {
            $this->crud->denyAccess('create');
        }
        if (!config('backpack.permissionmanager.allow_permission_update')) {
            $this->crud->denyAccess('update');
        }
        if (!config('backpack.permissionmanager.allow_permission_delete')) {
            $this->crud->denyAccess('delete');
        }
    }

    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }

    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
}
