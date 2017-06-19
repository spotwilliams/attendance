<?php

namespace Cat\Modules\Presentismo\Controllers\Registro;

use Cat\Models\Base;
use Cat\Models\Periodo;
use Cat\Models\Turno;
use Cat\Modules\Validation\Repositories\PresentismoRepository;
use Cat\Http\Controllers\AppBaseController;
use Cat\Repositories\PeriodoRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
            'base'  => 'required|not_in:-1',
            'turno' => 'not_in:-1',
        ]);
        
        $input = $request->all();
        
        return redirect(
            route(
                'presentismoListaAgentes',
                [
                    'base'  => $input['base'],
                    'desde' => $input['desde'],
                    'hasta' => $input['hasta'],
                    'turno' => $input['turno'],
                ]
            )
        );
        
    }
    
    public function listaAgentes(Request $request, $base, $desde, $hasta, $turno)
    {
        
        try {
            
            $base    = Base::findOrFail($base);
            $turno   = Turno::findOrFail($turno);
            $desde   = new \DateTime($desde);
            $hasta   = new \DateTime($hasta);
            $agentes = $this->presentismoRepository
                ->getEloquentAgentesBetweenDates(
                    $base,
                    $desde,
                    $hasta
                )
                ->with('contrato.tipoContrato')
                ->where('operativos.id_turno', '=', $turno->id);

        } catch (ModelNotFoundException $e) {
            Flash::error('Se ha seleccionado una base inexistente');
            
            return redirect(route('presentismoIndex'));
        }
        
        return view('Presentismo::registro.lista')
            ->with('desde', $desde)
            ->with('hasta', $hasta)
            ->with('turno', $turno)
            ->with('baseActual', $base)
            ->with('agentes', $agentes->paginate(25));
    }
    
}
