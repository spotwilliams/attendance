<?php

namespace Cat\Modules\Security\Controllers;

use Cat\Models\Base;
use Cat\Models\Turno;
use Cat\Modules\Security\Controllers\Crud\CrudController;
// VALIDATION
use Cat\Modules\Security\Models\Permission;
use Cat\Modules\Security\Models\Role;
use Cat\Modules\Security\Requests\RoleCrudRequest as StoreRequest;
use Cat\Modules\Security\Requests\RoleCrudRequest as UpdateRequest;

class RoleCrudController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel(Role::class);
        $this->crud->setEntityNameStrings('rol', 'roles');
        $this->crud->setRoute(url('seguridad/rol'));
        
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
            [
                'label'     => 'Turnos asignados',
                'type'      => 'select_multiple',
                'name'      => 'turnos', // the method that defines the relationship in your Model
                'entity'    => 'turnos', // the method that defines the relationship in your Model
                'attribute' => 'codigo', // foreign key attribute that is shown to user
                'model'     => Turno::class, // foreign key model
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
        
        $this->crud->addField([
            'label'     => 'Turnos con los que puede trabajar',
            'type'      => 'checklist',
            'name'      => 'turnos',
            'entity'    => 'turnos',
            'attribute' => 'codigo',
            'model'     => Turno::class,
            'pivot'     => true,
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
