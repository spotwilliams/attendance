<?php

namespace Cat\Modules\Configuracion\Turnos\Controllers;

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
     * Display a listing of the TurnoModel.
     *
     * @param Request $request
     * @return View
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
     * Show the form for creating a new TurnoModel.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', $this);
    
        return view('Configuracion::turnos.create');
    }
    
    /**
     * Store a newly created TurnoModel in storage.
     *
     * @param CreateTurnoModelRequest $request
     *
     * @return Response
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
     * Show the form for editing the specified TurnoModel.
     *
     * @param  int $id
     *
     * @return View
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
     * Update the specified TurnoModel in storage.
     *
     * @param  int $id
     * @param UpdateTurnoModelRequest $request
     *
     * @return Response
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
     * Remove the specified TurnoModel from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        return redirect(route('configuracion.turno.index'));
        
        $turnoModel = $this->turnoModelRepository->findWithoutFail($id);
        
        if (empty($turnoModel)) {
            Flash::error('Turno no encontrado');
            
            return redirect(route('configuracion.turno.index'));
        }
        
        $this->turnoModelRepository->delete($id);
        
        Flash::success('Turno borrado correctamente.');
        
    }
}
