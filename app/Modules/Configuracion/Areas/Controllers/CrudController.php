<?php

namespace Cat\Modules\Configuracion\Areas\Controllers;

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
     * Display a listing of the Area.
     *
     * @param Request $request
     * @return View
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
     * Show the form for creating a new Area.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', $this);
    
        return view('Configuracion::areas.create');
    }
    
    /**
     * Store a newly created Area in storage.
     *
     * @param CreateAreaRequest $request
     *
     * @return Response
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
     * Show the form for editing the specified Area.
     *
     * @param  int $id
     *
     * @return View
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
     * Update the specified Area in storage.
     *
     * @param  int $id
     * @param UpdateAreaRequest $request
     *
     * @return Response
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
     * Remove the specified Area from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        return redirect(route('configuracion.area.index'));
        
        $area = $this->areaRepository->findWithoutFail($id);
        
        if (empty($area)) {
            Flash::error('&Aacute;rea no encontrada');
            
            return redirect(route('configuracion.area.index'));
        }
        
        $this->areaRepository->delete($id);
        
        Flash::success('&Aacute;rea deleted correctamente.');
        
    }
}
