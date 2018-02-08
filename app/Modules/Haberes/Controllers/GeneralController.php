<?php

namespace Cat\Modules\Haberes\Controllers\Registro;

use Cat\Models\Base;
use Cat\Models\Contrato;
use Cat\Models\EstadoPeriodo;
use Cat\Models\Haber;
use Cat\Models\Operativo;
use Cat\Models\TipoContrato;
use Cat\Models\Turno;
use Cat\Modules\Validation\Repositories\PresentismoRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('selectBase', $this);
        
        /** @var Collection $operativos */
        $operativos = Operativo::select(['operativos.*'])
            ->join('agentes', 'operativos.id_agente', '=', 'agentes.id')
            ->join('contratos', function ($joinClause) {
                /** @var \Illuminate\Support\Collection $tipo */
                /** @var \Illuminate\Database\Query\JoinClause $joinClause */
                
                $tipo = TipoContrato::select('id')
                    ->where('codigo', 'LOCACION')
                    ->get();
                
                $joinClause->on('agentes.id', '=', 'contratos.id_agente')
                    ->whereIn('id_tipo_contrato', array_keys($tipo->keyBy('id')->toArray()));
            })
            ->get();
        
        /** @var Builder $eloq */
        $eloq = EstadoPeriodo::select(['estado_periodos.*'])
            ->with('turno')
            ->with('periodo')
            ->where('abierto', '=', true)
            ->orderBy('id_periodo', 'DESC');
        
        /**
         * @var integer $idBase
         * @var Collection $item
         */
        $eloq->where(function ($where) use($operativos ){
            
            foreach ($operativos->groupBy('id_base') as $idBase => $item) {
                $idTurnos = array_keys($item->keyBy('id_turno')->toArray());
                
                foreach ($idTurnos as $idTurno) {
                    $where->orWhere(function ($where) use ($idBase, $idTurno) {
                        $where->where('id_base', $idBase)
                            ->where('id_turno', $idTurno);
                    });
                }
            }
        });

        $estadoPeriodo = $eloq->get();
        
        return view('Haberes::calculo.index-estados-periodos')
            ->with('estadosPeriodos', $estadoPeriodo);
    }
    
    /**
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @deprecated
     */
    private function selectPeriodo(Request $request)
    {
        $this->authorize('selectPeriodo', $this);
        
        $this->validate($request, ['base' => 'not_in:-1', 'turno' => 'not_in:-1']);
        
        $this->authorize('base', $request);
        $this->authorize('turno', $request);
        
        $base  = Base::find($request->input('base'));
        $turno = Turno::find($request->input('turno'));
        
        return view('Haberes::calculo.index-periodo')
            ->with('base', $base)
            ->with('turno', $turno);
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @deprecated
     */
    private function prepareListaAgentes(Request $request)
    {
        $this->authorize('prepareListaAgentes', $this);
        try {
            
            $this->validate(
                $request,
                ['periodo' => 'not_in:-1']
            );
        } catch (ValidationException $e) {
            $base  = Base::find($request->input('base'));
            $turno = Turno::find($request->input('turno'));
            
            return view('Haberes::calculo.index-periodo')
                ->with('base', $base)
                ->with('turno', $turno)
                ->withErrors($e->validator->getMessageBag());
        }
        
        $input  = $request->all();
        $params = [
            'base'    => $input['base'],
            'periodo' => $input['periodo'],
            'turno'   => $input['turno'],
        ];
        
        return redirect(route('haberesListaAgentes', $params));
        
    }
    
    /**
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function listaAgentes(Request $request)
    {
        $this->authorize('listaAgentes', $this);
     
        try {
            /** @var EstadoPeriodo $estadoPeriodo */
            $estadoPeriodo = EstadoPeriodo::where('id', '=', $request->input('periodo'))
                ->with('base')
                ->with('turno')
                ->with('periodo')
                ->first();
            
            $periodo = $estadoPeriodo->periodo;
            $base    = $estadoPeriodo->base;
            $turno   = $estadoPeriodo->turno;
            
            $tipoLocacion = array_keys(TipoContrato::where('codigo', '=', Contrato::TIPO_LOCACION)
                ->get(['id'])
                ->keyBy('id')
                ->toArray());
            
            $agentesYaConfirmados = Haber::where('id_periodo', '=', $periodo->id)
                ->get(['id_agente'])->toArray();
            
            $agentes = $this
                ->presentismoRepository
                ->getEloquentAgentes($base->id, $periodo);
            
            $agentes
                ->select([
                    'agentes.id as id',
                    'agentes.nombre as nombre',
                    'agentes.apellido as apellido',
                    'agentes.cuit as cuit',
                ])
                // Override the condition
                ->with([
                    'presentismos' => function ($presentismos) use ($periodo) {
                        $presentismos
                            ->where('id_periodo', '=', $periodo->id)
//                            ->where('injustificado', '=', true)
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
                ->with('estadoPeriodo', $estadoPeriodo)
                ->with('turno', $turno);
        } catch (ModelNotFoundException $e) {
            Flash::error('No se ha podido continuar. Intente nuevamente');
            
            return view('Haberes::calculo.index-estados-periodos');
        }
        
    }
}
