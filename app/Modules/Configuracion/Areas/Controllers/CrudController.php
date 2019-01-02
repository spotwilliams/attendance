<?php

namespace Cat\Modules\Configuracion\Areas\Controllers;

use Cat\Models\Area;
use Cat\Modules\Configuracion\Areas\Requests\CreateAreaRequest;
use Cat\Modules\Configuracion\Areas\Requests\UpdateAreaRequest;
use Cat\Modules\Configuracion\Areas\Repositories\AreaRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Illuminate\View\View;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

class CrudController extends AppBaseController
{
    /** @var  AreaRepository */
    private $areaRepository;
    
    public function __construct(AreaRepository $areaRepo)
    {
        $this->areaRepository = $areaRepo;
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
        
        $this->areaRepository->pushCriteria(new RequestCriteria($request));
        $areas = $this->areaRepository->all();
        
        return view('Configuracion::areas.index')
            ->with('areas', $areas);
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', $this);
    
        return view('Configuracion::areas.create');
    }
    
    /**
     * @param CreateAreaRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CreateAreaRequest $request)
    {
        $this->authorize('store', $this);
    
        $input = $request->all();
        
        $area = $this->areaRepository->create($input);
        
        Flash::success('&Aacute;rea guardada correctamente.');
        
        return redirect(route('configuracion.area.index'));
    }
    
    /**
     * Display the specified Area.
     *
     * @param  int $id
     *
     * @return View
     */
    public function show($id)
    {
        $area = $this->areaRepository->findWithoutFail($id);
        
        if (empty($area)) {
            Flash::error('&Aacute;rea no encontrada');
            
            return redirect(route('configuracion.area.index'));
        }
        
        return view('Configuracion::areas.show')->with('area', $area);
    }
    
    /**
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($id)
    {
        $this->authorize('edit', $this);
    
        $area = $this->areaRepository->findWithoutFail($id);
        
        if (empty($area)) {
            Flash::error('&Aacute;rea no encontrada');
            
            return redirect(route('configuracion.area.index'));
        }
        
        return view('Configuracion::areas.edit')->with('area', $area);
    }
    
    /**
     * @param $id
     * @param UpdateAreaRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update($id, UpdateAreaRequest $request)
    {
        $this->authorize('update', $this);
    
        $area = $this->areaRepository->findWithoutFail($id);
        
        if (empty($area)) {
            Flash::error('&Aacute;rea no encontrada');
            
            return redirect(route('configuracion.area.index'));
        }
        
        $area = $this->areaRepository->update($request->all(), $id);
        
        Flash::success('&Aacute;rea actualizada correctamente.');
        
        return redirect(route('configuracion.area.index'));
    }
    
    /**
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete($id)
    {
        $this->authorize('delete', $this);
        
        $area = Area::where('id', '=', $id)
            ->with('operativos.agente')
            ->first();

        if (empty($area)) {
            Flash::error('&Aacute;rea no encontrada');
            
            return redirect(route('configuracion.area.index'));
        }
        
        return view('Configuracion::areas.delete')
            ->with('area', $area);
    }
    
    
    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        $this->authorize('destroy', $this);
    
        $area = Area::where('id', '=', $id)
            ->with('operativos.agente')
            ->first();
        
        if (empty($area)) {
            Flash::error('&Aacute;rea no encontrada');
            
            return redirect(route('configuracion.area.index'));
        } else {
            
            if (!$area->operativos->isEmpty()) {
                Flash::error('No se pueden eliminar &aacute;reas con agentes asignados.');
                
                return redirect(route('configuracion.area.delete', ['id' => $area->id]));
            } else {
                $this->areaRepository->delete($id);
                Flash::success('&Aacute;rea eliminada correctamente.');
                
                return redirect(route('configuracion.area.index'));
            }
        }
        
        
    }
}
