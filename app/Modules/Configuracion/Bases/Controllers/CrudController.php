<?php

namespace Cat\Modules\Configuracion\Bases\Controllers;

use Cat\Modules\Configuracion\Bases\Requests\CreateBaseModelRequest;
use Cat\Modules\Configuracion\Bases\Requests\UpdateBaseModelRequest;
use Cat\Modules\Configuracion\Bases\Repositories\CrudRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laracasts\Flash\Flash;
use Prettus\Repository\Criteria\RequestCriteria;
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
     * Display a listing of the BaseModel.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        $this->baseModelRepository->pushCriteria(new RequestCriteria($request));
        $baseModels = $this->baseModelRepository->all();
        
        return view('Configuracion::bases.index')
            ->with('baseModels', $baseModels);
    }
    
    /**
     * Show the form for creating a new BaseModel.
     *
     * @return Response
     */
    public function create()
    {
        return view('Configuracion::bases.create');
    }
    
    /**
     * Store a newly created BaseModel in storage.
     *
     * @param CreateBaseModelRequest $request
     *
     * @return Response
     */
    public function store(CreateBaseModelRequest $request)
    {
        $input = $request->all();
        
        $baseModel = $this->baseModelRepository->create($input);
        
        Flash::success('Base Model saved successfully.');
        
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
            Flash::error('Base Model not found');
            
            return redirect(route('configuracion.base.index'));
        }
        
        return view('Configuracion::bases.show')->with('baseModel', $baseModel);
    }
    
    /**
     * Show the form for editing the specified BaseModel.
     *
     * @param  int $id
     *
     * @return View
     */
    public function edit($id)
    {
        $baseModel = $this->baseModelRepository->findWithoutFail($id);
        
        if (empty($baseModel)) {
            Flash::error('Base Model not found');
            
            return redirect(route('configuracion.base.index'));
        }
        
        return view('Configuracion::bases.edit')->with('baseModel', $baseModel);
    }
    
    /**
     * Update the specified BaseModel in storage.
     *
     * @param  int $id
     * @param UpdateBaseModelRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBaseModelRequest $request)
    {
        $baseModel = $this->baseModelRepository->findWithoutFail($id);
        
        if (empty($baseModel)) {
            Flash::error('Base Model not found');
            
            return redirect(route('configuracion.base.index'));
        }
        
        $baseModel = $this->baseModelRepository->update($request->all(), $id);
        
        Flash::success('Base Model updated successfully.');
        
        return redirect(route('configuracion.base.index'));
    }
    
    /**
     * Remove the specified BaseModel from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    private function destroy($id)
    {
        $baseModel = $this->baseModelRepository->findWithoutFail($id);
        
        if (empty($baseModel)) {
            Flash::error('Base Model not found');
            
            return redirect(route('configuracion.base.index'));
        }
        
        $this->baseModelRepository->delete($id);
        
        Flash::success('Base Model deleted successfully.');
        
        return redirect(route('configuracion.base.index'));
    }
}
