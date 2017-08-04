<?php

namespace Cat\Modules\Security\Controllers;

use Cat\Modules\Security\Controllers\Crud\CrudController;
// VALIDATION
use Cat\Modules\Security\Models\Permission;
use Cat\Modules\Security\Models\Role;
use Cat\Modules\Security\Requests\PermissionCrudRequest as StoreRequest;
use Cat\Modules\Security\Requests\PermissionCrudRequest as UpdateRequest;
use Cat\User;
use Illuminate\Support\Collection;

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
        // Quito todos los botones
        $this->crud->buttons = new Collection();

    }
    
    public function create()
    {
        return redirect($this->crud->route);
    }
    
    public function edit($id)
    {
        return redirect($this->crud->route);
    }
    
    public function store(StoreRequest $request)
    {
        return redirect($this->crud->route);
    }
    
    public function update(UpdateRequest $request)
    {
        return redirect($this->crud->route);
    }
    
    public function destroy($id)
    {
        return redirect($this->crud->route);
    }
    
}
