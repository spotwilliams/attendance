<?php

namespace Cat\Security\Controllers;

use Cat\Models\Base;
use Cat\Security\Controllers\Crud\CrudController;
// VALIDATION
use Cat\Security\Models\Permission;
use Cat\Security\Models\Role;
use Cat\Security\Requests\RoleCrudRequest as StoreRequest;
use Cat\Security\Requests\RoleCrudRequest as UpdateRequest;

class RoleCrudController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel(Role::class);
        $this->crud->setEntityNameStrings('Rol', 'Roles');
        $this->crud->setRoute(url('administracion/rol'));
        
        $this->crud->setColumns([
            [
                'name'  => 'name',
                'label' => 'Nombre rol',
                'type'  => 'text',
            ],
            [
                // n-n relationship (with pivot table)
                'label'     => 'Permisos asignados',
                'type'      => 'select_multiple',
                'name'      => 'permissions', // the method that defines the relationship in your Model
                'entity'    => 'permissions', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => Permission::class, // foreign key model
                'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?
            ],
            [
                'label'     => 'Bases asignados',
                'type'      => 'select_multiple',
                'name'      => 'bases', // the method that defines the relationship in your Model
                'entity'    => 'bases', // the method that defines the relationship in your Model
                'attribute' => 'nombre', // foreign key attribute that is shown to user
                'model'     => Base::class, // foreign key model
                'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?
            ],
        ]);
        
        $this->crud->addField([
            'name'  => 'name',
            'label' => 'Nombre',
            'type'  => 'text',
        ]);
        
        $this->crud->addField([
            'label'     => 'Permisos a asignar',
            'type'      => 'checklist',
            'name'      => 'permissions',
            'entity'    => 'permissions',
            'attribute' => 'name',
            'model'     => Permission::class,
            'pivot'     => true,
        ]);
        
        $this->crud->addField([
            'label'     => 'Bases con las que puede trabajar',
            'type'      => 'checklist',
            'name'      => 'bases',
            'entity'    => 'bases',
            'attribute' => 'nombre',
            'model'     => Base::class,
            'pivot'     => true,
        ]);
        
        if (config('backpack.permissionmanager.allow_role_create') == false) {
            $this->crud->denyAccess('create');
        }
        if (config('backpack.permissionmanager.allow_role_update') == false) {
            $this->crud->denyAccess('update');
        }
        if (config('backpack.permissionmanager.allow_role_delete') == false) {
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
