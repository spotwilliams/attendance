<?php

namespace Cat\Modules\Configuracion\Turnos\Controllers;

use Cat\Models\Turno;
use Cat\Modules\Configuracion\Turnos\Requests\CreateTurnoModelRequest;
use Cat\Modules\Configuracion\Turnos\Requests\UpdateTurnoModelRequest;
use Cat\Modules\Configuracion\Turnos\Repositories\TurnoModelRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laracasts\Flash\Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

class CrudController extends AppBaseController
{
    /** @var  TurnoModelRepository */
    private $turnoModelRepository;
    
    public function __construct(TurnoModelRepository $turnoModelRepo)
    {
        $this->turnoModelRepository = $turnoModelRepo;
    }
    
    /**
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function index(Request $request)
    {
        $this->authorize('index', $this);
    
        $this->turnoModelRepository->pushCriteria(new RequestCriteria($request));
        $turnoModels = $this->turnoModelRepository->all();
        
        return view('Configuracion::turnos.index')
            ->with('turnoModels', $turnoModels);
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', $this);
    
        return view('Configuracion::turnos.create');
    }
    
    /**
     * @param CreateTurnoModelRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CreateTurnoModelRequest $request)
    {
        $this->authorize('store', $this);
    
        $input = $request->all();
        
        $turnoModel = $this->turnoModelRepository->create($input);
        
        Flash::success('Turno guardado correctamente.');
        
        return redirect(route('configuracion.turno.index'));
    }
    
    /**
     * Display the specified TurnoModel.
     *
     * @param  int $id
     *
     * @return View
     */
    public function show($id)
    {
        $turnoModel = $this->turnoModelRepository->findWithoutFail($id);
        
        if (empty($turnoModel)) {
            Flash::error('Turno no encontrado');
            
            return redirect(route('configuracion.turno.index'));
        }
        
        return view('Configuracion::turnos.show')->with('turnoModel', $turnoModel);
    }
    
    /**
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($id)
    {
        $this->authorize('edit', $this);
    
        $turnoModel = $this->turnoModelRepository->findWithoutFail($id);
        
        if (empty($turnoModel)) {
            Flash::error('Turno no encontrado');
            
            return redirect(route('configuracion.turno.index'));
        }
        
        return view('Configuracion::turnos.edit')->with('turnoModel', $turnoModel);
    }
    
    /**
     * @param $id
     * @param UpdateTurnoModelRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update($id, UpdateTurnoModelRequest $request)
    {
        $this->authorize('update', $this);
    
        $turnoModel = $this->turnoModelRepository->findWithoutFail($id);
        
        if (empty($turnoModel)) {
            Flash::error('Turno no encontrado');
            
            return redirect(route('configuracion.turno.index'));
        }
        
        $turnoModel = $this->turnoModelRepository->update($request->all(), $id);
        
        Flash::success('Turno actualizado correctamente.');
        
        return redirect(route('configuracion.turno.index'));
    }
    
    /**
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete($id)
    {
        $this->authorize('delete', $this);
        
        $turnoModel = Turno::where('id', '=', $id)
            ->with('operativos.agente')
            ->first();
        
        if (empty($turnoModel)) {
            Flash::error('Turno no encontrado');
            
            return redirect(route('configuracion.turno.index'));
        }
        
        return view('Configuracion::turnos.delete')->with('turnoModel', $turnoModel);
    }
    
    
    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        $this->authorize('destroy', $this);
    
        $turnoModel = Turno::where('id', '=', $id)
            ->with('operativos.agente')
            ->first();
        
        if (empty($turnoModel)) {
            Flash::error('Turno no encontrado');
            
            return redirect(route('configuracion.turno.index'));
        } else {
            
            if (!$turnoModel->operativos->isEmpty()) {
                Flash::error('No se pueden eliminar turnos con agentes asignados.');
                
                return redirect(route('configuracion.turno.delete', ['id' => $turnoModel->id]));
            } else {
                $this->turnoModelRepository->delete($id);
                Flash::success('Turno eliminado correctamente.');
                
                return redirect(route('configuracion.turno.index'));
            }
        }
        
        
    }
}
