<?php

namespace Cat\Modules\Haberes\Controllers;

use Cat\Helpers\Pagination\FormPresenter;
use Cat\Models\Base;
use Cat\Models\Contrato;
use Cat\Models\EstadoPeriodo;
use Cat\Models\Haber;
use Cat\Models\Operativo;
use Cat\Models\Periodo;
use Cat\Models\TipoContrato;
use Cat\Models\Turno;
use Cat\Modules\Presentismo\Exceptions\Validacion\PeriodoAbierto;
use Cat\Modules\Validation\Repositories\PresentismoRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Laracasts\Flash\Flash;

class GeneralController extends AppBaseController
{
    /** @var  PresentismoRepository */
    private $presentismoRepository;
    
    public function __construct(PresentismoRepository $presentismoRepo)
    {
        $this->presentismoRepository = $presentismoRepo;
        $this->middleware('auth');
        
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('selectBase', $this);
        
        return view('Haberes::calculo.seleccionar-periodos');
    }
    
    
    public function search(Request $request)
    {
        try {
            /** @var Periodo $periodo */
            $periodo = Periodo::findOrFail($request->input('periodo'));
            
            $periodo->validarSiPuedeCalcular();
            
            return view('Haberes::calculo.seleccionar-agentes')
                ->with('periodo', $periodo);
        } catch (ModelNotFoundException $e) {
            Flash::error('Debe seleccionar un periodo de la lista');
            
            return redirect(route('haberesIndex'));
        } catch (PeriodoAbierto $e) {
            Flash::error($e->getMessage());
            
            return redirect()->route('haberesIndex');
        }
    }
}
