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
            'label' => 'Nombre permiso',
            'type'  => 'text',
        ]);


        $this->crud->addField([
            'name'  => 'name',
            'label' => 'Nombre permiso',
            'type'  => 'text',
        ]);
        
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
