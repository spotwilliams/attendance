<?php

namespace Cat\Modules\Haberes\Controllers\Registro;

use Cat\Models\Base;
use Cat\Models\Periodo;
use Cat\Modules\Validation\Repositories\PresentismoRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
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
    public function selectBase(Request $request, $base)
    {
        return view('Haberes::calculo.index-base')
            ->with('baseActual', $base);
    }
    
    /**
     * Display a listing of the Presentismo.
     *
     * @param Request $request
     * @return Response
     */
    public function selectPeriodo(Request $request)
    {
        return view('Haberes::calculo.index-periodo')
            ->with('baseActual', $request->input('base'));
    }
    
    public function prepareListaAgentes(Request $request)
    {
        
        $input = $request->all();
        
        return redirect(route('haberesListaAgentes', ['base' => $input['base'], 'periodo' => $input['periodo']]));
        
    }
    
    public function listaAgentes(Request $request, $base, $periodo)
    {
        try {
            $periodo = Periodo::findOrFail($periodo);
            $base    = Base::findOrFail($base);
            $agentes = $this
                ->presentismoRepository
                ->getEloquentAgentes($base->id, $periodo);
            
            $agentes
                ->with([
                    'haberes' => function ($haberBuilder) use ($periodo) {
                        $haberBuilder->where('id_periodo', '=', $periodo->id);
                    },
                ])
                ->with('contrato');
//                ->whereNotIn('agentes.id', function ($query) use ($periodo) {
//                    /** @var Builder */
//                    $query->from('haberes')
//                        ->select('id_agente as id')
//                        ->where('id_periodo', '=', $periodo->id);
//                });
            
            
            return view('Haberes::calculo.lista')
                ->with('agentes', $agentes->paginate(25))
                ->with('base', $base)
                ->with('periodo', $periodo);
        } catch (ModelNotFoundException $e) {
            Flash::error('No se ha podido continuar. Intente nuevamente');
            
            return view('Haberes::calculo.index-base')
                ->with('baseActual', 1);
        }
        
    }
}
