<?php

namespace Cat\Modules\Configuracion\TipoPresentismos\Controllers;

use Cat\Modules\Configuracion\TipoPresentismos\Requests\CreateTipoPresentismoRequest;
use Cat\Modules\Configuracion\TipoPresentismos\Requests\UpdateTipoPresentismoRequest;
use Cat\Modules\Configuracion\TipoPresentismos\Repositories\TipoPresentismoRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Illuminate\View\View;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

class CrudController extends AppBaseController
{
    /** @var  TipoPresentismoRepository */
    private $repository;
    
    public function __construct(TipoPresentismoRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * Display a listing of the Area.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        $this->authorize('index', $this);
        
        $this->repository->pushCriteria(new RequestCriteria($request));
        $tipos = $this->repository->all();
        
        return view('Configuracion::tipo_presentismo.index')
            ->with('tipos', $tipos);
    }
    
    /**
     * Show the form for creating a new Area.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', $this);
        
        return view('Configuracion::tipo_presentismo.create');
    }
    
    /**
     * Store a newly created Area in storage.
     *
     * @param CreateAreaRequest $request
     *
     * @return Response
     */
    public function store(CreateTipoPresentismoRequest $request)
    {
        $this->authorize('store', $this);
        
        $input = $request->all();
        
        $area = $this->repository->create($input);
        
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
        $area = $this->repository->findWithoutFail($id);
        
        if (empty($area)) {
            Flash::error('&Aacute;rea no encontrada');
            
            return redirect(route('configuracion.area.index'));
        }
        
        return view('Configuracion::tipo_presentismo.show')->with('area', $area);
    }
    
    /**
     * Show the form for editing the specified Area.
     *
     * @param  int $id
     *
     * @return View
     */
    public function edit($id)
    {
        $this->authorize('edit', $this);
        
        $tipo = $this->repository->findWithoutFail($id);
        
        if (empty($tipo)) {
            Flash::error('&Aacute;rea no encontrada');
            
            return redirect(route('configuracion.area.index'));
        }
        
        return view('Configuracion::tipo_presentismo.edit')->with('tipo', $tipo);
    }
    
    /**
     * Update the specified Area in storage.
     *
     * @param  int $id
     * @param UpdateAreaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTipoPresentismoRequest $request)
    {
        $this->authorize('update', $this);
        
        $area = $this->repository->findWithoutFail($id);
        
        if (empty($area)) {
            Flash::error('&Aacute;rea no encontrada');
            
            return redirect(route('configuracion.area.index'));
        }
        
        $area = $this->repository->update($request->all(), $id);
        
        Flash::success('&Aacute;rea actualizada correctamente.');
        
        return redirect(route('configuracion.area.index'));
    }
    
    /**
     * Remove the specified Area from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        return redirect(route('configuracion.area.index'));
        
        $area = $this->repository->findWithoutFail($id);
        
        if (empty($area)) {
            Flash::error('&Aacute;rea no encontrada');
            
            return redirect(route('configuracion.area.index'));
        }
        
        $this->repository->delete($id);
        
        Flash::success('&Aacute;rea deleted correctamente.');
        
    }
}
