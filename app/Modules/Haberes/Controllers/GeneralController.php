<?php

namespace Cat\Modules\Haberes\Controllers;

use Cat\Http\Controllers\AppBaseController;
use Cat\Models\Periodo;
use Cat\Modules\Presentismo\Exceptions\Validacion\PeriodoAbierto;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laracasts\Flash\Flash;

class GeneralController extends AppBaseController
{
    
    /** @var string */
    protected $indexView;
    
    /** @var string */
    protected $searchView;
    
    /** @var string */
    protected $indexRoute;
    
    
    public function __construct()
    {
        $this->middleware('auth');
        
        $this->indexView  = 'Haberes::calculo.seleccionar-periodos';
        $this->searchView = 'Haberes::calculo.seleccionar-agentes';
        $this->indexRoute = 'haberesIndex';
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', $this);
        
        return view($this->indexView);
    }
    
    
    public function search(Request $request)
    {
        try {
            /** @var Periodo $periodo */
            $periodo = Periodo::findOrFail($request->input('periodo'));
            
            $periodo->validarSiPuedeCalcular();
            
            return view($this->searchView)
                ->with('periodo', $periodo);
        } catch (ModelNotFoundException $e) {
            Flash::error('Debe seleccionar un periodo de la lista');
            
            return redirect(route($this->indexRoute));
        } catch (PeriodoAbierto $e) {
            Flash::error($e->getMessage());


            return redirect()->route($this->indexRoute);
        }
    }
}
