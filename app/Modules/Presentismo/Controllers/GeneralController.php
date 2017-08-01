<?php

namespace Cat\Modules\Presentismo\Controllers\Registro;

use Cat\Helpers\Calculation;
use Cat\Helpers\Pagination\FormPresenter;
use Cat\Models\Base;
use Cat\Models\Periodo;
use Cat\Models\Turno;
use Cat\Modules\Validation\Repositories\PresentismoRepository;
use Cat\Http\Controllers\AppBaseController;
use Cat\Repositories\PeriodoRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Response;

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
     * Display a listing of the Presentismo.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        // Se ejecuta para generar un periodo en caso que no exista
        PeriodoRepository::getOrCreatePeriodoActivo();
        
        return view('Presentismo::registro.index');
    }
    
    public function prepareListaAgentes(Request $request)
    {
        $this->validate($request, [
            'base'   => 'required|not_in:-1',
            'turnos' => 'required',
            'areas'  => 'required',
        ]);
        
        $input = $request->all();
        
        return $this->listaAgentes(
            $request,
            $input['base'],
            $input['turnos'],
            $input['areas'],
            $input['desde'],
            $input['hasta'],
            $input['funcion']
        );
    }
    
    /**
     * @param $request Request
     * @param $base int
     * @param $turnos array
     * @param $areas array
     * @param $desde string (US date format)
     * @param $hasta string (US date format)
     * @param $funcion int
     * @return mixed
     */
    private function listaAgentes(
        Request $request,
        $base,
        $turnos,
        $areas,
        $desde,
        $hasta,
        $funcion
    ) {
        try {
            
            $base = Base::findOrFail($base);
            
            // Controlamos que solo existan 10 dias como maximo
            $dateRange = Calculation::prepareTenDaysDiff($desde, $hasta);
            
            $agentes = $this->presentismoRepository
                ->getEloquentAgentesBetweenDates(
                    $base,
                    $dateRange['desde'],
                    $dateRange['hasta']
                )
                ->whereIn('operativos.id_turno', $turnos)
                ->whereIn('operativos.id_area', $areas)
                // En caso que pasemos una funcion la buscamos, sino la excluimos desde sql
                ->where('operativos.id_funcion', (($funcion == -1) ? '<>' : '='), $funcion)
                ->with('contrato.tipoContrato');
            
            /** @var LengthAwarePaginator $result */
            $result = $agentes->paginate(25);
        } catch (ModelNotFoundException $e) {
            Flash::error('Se ha seleccionado una base inexistente');
            
            return redirect(route('presentismoIndex'));
        }
        
        $presenter = new FormPresenter($result, 'presentismoPrepareListaAgentes');
        $presenter->setInputsParams($request->all());

        return view('Presentismo::registro.lista')
            ->with('desde', $dateRange['desde'])
            ->with('hasta', $dateRange['hasta'])
            ->with('turnos', new Collection($turnos))
            ->with('areas', new Collection($areas))
            ->with('links', $result->links($presenter))
            ->with('baseActual', $base)
            ->with('agentes', $result);
    }
    
}
