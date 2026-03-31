<?php

namespace Cat\Modules\Configuracion\Bases\Controllers;

use Cat\Models\Base;
use Cat\Modules\Configuracion\Bases\Requests\CreateBaseModelRequest;
use Cat\Modules\Configuracion\Bases\Requests\UpdateBaseModelRequest;
use Cat\Modules\Configuracion\Bases\Repositories\CrudRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\View\View;
use Laracasts\Flash\Flash;
use Illuminate\Http\Response;

class CrudController extends AppBaseController
{
    /** @var  CrudRepository */
    private $baseModelRepository;
    
    public function __construct(CrudRepository $baseModelRepo)
    {
        $this->baseModelRepository = $baseModelRepo;
    }
    
    /**
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', $this);

        $baseModels = $this->baseModelRepository->all();
        
        return view('Configuracion::bases.index')
            ->with('baseModels', $baseModels);
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', $this);
        
        return view('Configuracion::bases.create');
    }
    
    /**
     * @param CreateBaseModelRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CreateBaseModelRequest $request)
    {
        $this->authorize('store', $this);
        
        $input = $request->all();
        
        $baseModel = $this->baseModelRepository->create($input);
        
        Flash::success('Base creada correctamente.');
        
        return redirect(route('configuracion.base.index'));
    }
    
    /**
     * Display the specified BaseModel.
     *
     * @param  int $id
     *
     * @return View
     */
    public function show($id)
    {
        $baseModel = $this->baseModelRepository->findWithoutFail($id);
        
        if (empty($baseModel)) {
            Flash::error('Base no encontrada');
            
            return redirect(route('configuracion.base.index'));
        }
        
        return view('Configuracion::bases.show')->with('baseModel', $baseModel);
    }
    
    /**
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($id)
    {
        $this->authorize('edit', $this);
        
        $baseModel = $this->baseModelRepository->findWithoutFail($id);
        
        if (empty($baseModel)) {
            Flash::error('Base no encontrada');
            
            return redirect(route('configuracion.base.index'));
        }
        
        return view('Configuracion::bases.edit')->with('baseModel', $baseModel);
    }
    
    /**
     * @param $id
     * @param UpdateBaseModelRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update($id, UpdateBaseModelRequest $request)
    {
        $this->authorize('update', $this);
        
        $baseModel = $this->baseModelRepository->findWithoutFail($id);
        
        if (empty($baseModel)) {
            Flash::error('Base no encontrada');
            
            return redirect(route('configuracion.base.index'));
        }
        
        $baseModel = $this->baseModelRepository->update($request->all(), $id);
        
        Flash::success('Base actualizada correctamente.');
        
        return redirect(route('configuracion.base.index'));
    }
    
    /**
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete($id)
    {
        $this->authorize('delete', $this);
        
        $baseModel = Base::where('id', '=', $id)
            ->with('operativos.agente')
            ->first();
        
        if (empty($baseModel)) {
            Flash::error('Base no encontrada');
            
            return redirect(route('configuracion.base.index'));
        }
        
        return view('Configuracion::bases.delete')->with('baseModel', $baseModel);
    }
    
    
    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        $this->authorize('destroy', $this);
    
        $baseModel = Base::where('id', '=', $id)
            ->with('operativos.agente')
            ->first();
        
        if (empty($baseModel)) {
            Flash::error('Base no encontrada');
            
            return redirect(route('configuracion.base.index'));
        } else {
            
            if (!$baseModel->operativos->isEmpty()) {
                Flash::error('No se pueden eliminar bases con agentes asignados.');
                
                return redirect(route('configuracion.base.delete', ['id' => $baseModel->id]));
            } else {
                $this->baseModelRepository->delete($id);
                Flash::success('Base eliminada correctamente.');
                
                return redirect(route('configuracion.base.index'));
            }
        }
        
        
    }
}
