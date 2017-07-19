<?php

namespace Cat\Security\Controllers;


use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Security\Requests\UserStoreCrudRequest as StoreRequest;
// VALIDATION
use Cat\Security\Requests\UserUpdateCrudRequest as UpdateRequest;
use Cat\Security\Controllers\Crud\CrudController;
use Cat\Security\Models\Permission;
use Cat\Security\Models\Role;
use Cat\User;
use Laracasts\Flash\Flash;

class UserCrudController extends CrudController
{
    
    
    public function setup()
    {
        $this->crud->setModel(User::class, ['agente']);
        $this->crud->setEntityNameStrings('Usuario', 'Usuarios');
        $this->crud->setRoute(url('administracion/usuario'));
        
        $this->setupColumns();
        $this->setupFields();
    }
    
    
    private function setupFields()
    {
        $this->crud->addFields([
            [
                'name'  => 'name',
                'label' => 'Nombre',
                'type'  => 'text',
            ],
            [
                'name'  => 'email',
                'label' => 'Email',
                'type'  => 'email',
            ],
            [
                'name'  => 'password',
                'label' => 'Contrase&ntilde;a',
                'type'  => 'password',
            ],
            [
                'name'  => 'password_confirmation',
                'label' => 'Confirme contrase&ntilde;a',
                'type'  => 'password',
            ],
            [
                'label'     => 'Roles que puede asignarse',
                'type'      => 'checklist',
                'name'      => 'roles',
                'entity'    => 'roles',
                'attribute' => 'name',
                'model'     => Role::class,
                'pivot'     => true,
            ],
        ]);
        
    }
    
    private function setupColumns()
    {
        $this->crud->setColumns([
            [
                'name'  => 'name',
                'label' => 'Nombre',
                'type'  => 'text',
            ],
        ]);
        $this->crud->setColumns([
            [
                'name'  => 'email',
                'label' => 'Email',
                'type'  => 'email',
            ],
        ]);
        $this->crud->addColumn([ // n-n relationship (with pivot table)
                                 'label'     => 'Rol', // Table column heading
                                 'type'      => 'select_multiple',
                                 'name'      => 'roles', // the method that defines the relationship in your Model
                                 'entity'    => 'roles', // the method that defines the relationship in your Model
                                 'attribute' => 'name', // foreign key attribute that is shown to user
                                 'model'     => Role::class, // foreign key model
        ]);
    }
    
    /**
     * Store a newly created resource in the database.
     *
     * @param StoreRequest $request - type injection used for validation using Requests
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $this->crud->hasAccessOrFail('create');
        
        // insert item in the db
        if ($request->input('password')) {
            $item = $this->crud->create(\Request::except(['redirect_after_save']));
            
            // now bcrypt the password
            $item->password = bcrypt($request->input('password'));
            $item->save();
        } else {
            $item = $this->crud->create(\Request::except(['redirect_after_save', 'password']));
        }
        
        // show a success message
        Flash::success('Guardado correctamente');
        
        // redirect the user where he chose to be redirected
        switch (\Request::input('redirect_after_save')) {
            case 'current_item_edit':
                return \Redirect::to($this->crud->route . '/' . $item->id . '/edit');
            
            default:
                return \Redirect::to(\Request::input('redirect_after_save'));
        }
    }
    
    public function update(UpdateRequest $request)
    {
        
        //encrypt password and set it to request
        $this->crud->hasAccessOrFail('update');
        
        $dataToUpdate = \Request::except(['redirect_after_save', 'password']);
        
        //encrypt password
        if ($request->input('password')) {
            $dataToUpdate['password'] = bcrypt($request->input('password'));
        }
        
        // update the row in the db
        $this->crud->update(\Request::get($this->crud->model->getKeyName()), $dataToUpdate);
        
        // show a success message
        Flash::success('Actualizado correctamente');
        
        return \Redirect::to($this->crud->route);
    }
}
