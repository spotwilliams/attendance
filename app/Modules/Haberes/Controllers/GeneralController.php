<?php

namespace Cat\Modules\Haberes\Controllers\Registro;

use Cat\Models\Base;
use Cat\Models\Contrato;
use Cat\Models\Haber;
use Cat\Models\Periodo;
use Cat\Models\TipoContrato;
use Cat\Models\Turno;
use Cat\Modules\Validation\Repositories\PresentismoRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
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
    public function selectBase(Request $request)
    {
        return view('Haberes::calculo.index-base');
    }
    
    /**
     * @param Request $request
     * @return View
     */
    public function selectPeriodo(Request $request)
    {
        $this->validate($request, ['base' => 'not_in:-1']);
        
        $base = Base::find($request->input('base'));
        
        return view('Haberes::calculo.index-periodo')
            ->with('base', $base);
    }
    
    public function prepareListaAgentes(Request $request)
    {
        $this->validate(
            $request,
            ['turno' => 'not_in:-1', 'periodo' => 'not_in:-1']
        );
        
        $input  = $request->all();
        $params = [
            'base'    => $input['base'],
            'periodo' => $input['periodo'],
            'turno'   => $input['turno'],
        ];
        
        return redirect(route('haberesListaAgentes', $params));
        
    }
    
    public function listaAgentes(Request $request, $base, $periodo, $turno)
    {
        try {
            $periodo              = Periodo::findOrFail($periodo);
            $base                 = Base::findOrFail($base);
            $tipoLocacion         = array_keys(TipoContrato::where('codigo', '=', Contrato::TIPO_LOCACION)
                ->get(['id'])
                ->keyBy('id')
                ->toArray());
            $turno                = Turno::findOrFail($turno);
            $agentesYaConfirmados = Haber::where('id_periodo', '=', $periodo->id)
                ->get(['id_agente'])->toArray();
            $desde                = new \DateTime($periodo->fecha_comienzo);
            $hasta                = new \DateTime($periodo->fecha_fin);
            
            $agentes = $this
                ->presentismoRepository
                ->getEloquentAgentes($base->id, $periodo);
            
            $agentes
//                ->with([
//                    'haberes' => function ($haberBuilder) use ($periodo) {
//                        $haberBuilder->where('id_periodo', '=', $periodo->id);
//                    },
//                ])
                // Override the condition
                ->with([
                    'presentismos' => function ($presentismos) use ($desde, $hasta) {
                        $presentismos
                            ->whereDate('fecha', '>=', $desde->format('Y-m-d'))
                            ->whereDate('fecha', '<=', $hasta->format('Y-m-d'))
                            ->where('injustificado', '=', 1)
                            ->orderBy('fecha', 'ASC');
                    },
                ])
                ->with('contrato.tipoContrato')
                ->whereNotIn('agentes.id', $agentesYaConfirmados)
                ->whereIn('contratos.id_tipo_contrato', $tipoLocacion)
                ->where('operativos.id_turno', '=', $turno->id);
            
            return view('Haberes::calculo.lista')
                ->with('agentes', $agentes->paginate(25))
                ->with('base', $base)
                ->with('periodo', $periodo)
                ->with('turno', $turno);
        } catch (ModelNotFoundException $e) {
            Flash::error('No se ha podido continuar. Intente nuevamente');
            
            return view('Haberes::calculo.index-base')
                ->with('baseActual', 1);
        }
        
    }
}
