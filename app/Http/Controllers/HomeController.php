<?php

namespace Cat\Http\Controllers;

use Cat\Helpers\Calculation;
use Cat\Models\Base;
use Cat\Models\EstadoContrato;
use Cat\Models\Param;
use Cat\Models\Presentismo;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Cat\Repositories\PeriodoRepository;
use Cat\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Query\JoinClause;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PeriodoRepository $repo)
    {
        $today       = new \DateTime('now');
        $periodo     = $repo->getOrCreatePeriodoActivo($today);
        $fechaCierre = Param::fechaCierre();
        $tipoPresen  = TipoPresentismo::where('codigo', '=', TipoPresentismo::PRESENTE)->first();
        $presentes   = Presentismo::where('id_periodo', '=', $periodo->id)
            ->where('id_tipo_presentismo', '=', $tipoPresen->id)
            ->count();
        
        $allPresen     = Presentismo::where('id_periodo', '=', $periodo->id)
            ->count();
        $allPresen     = $allPresen ?: 1;
        
        $agentesActivo = AgenteRepository::getCountActivos();
        
        try {
            $this->authorize('index', $this);
            
            $start     = (new \DateTime('now'))->modify('-4day');
            $cantBases = Base::count();
            $cantUsers = User::count();
            $fechas    = Calculation::getAllDaysBetween($start, $today);
            
            
            return view('dashboard')
                ->with('cantBases', $cantBases)
                ->with('cantUsers', $cantUsers)
                ->with('cantAgentes', $agentesActivo)
                ->with('periodo', $periodo)
                ->with('fechaCierre', $fechaCierre)
                ->with('presentes', $presentes)
                ->with('allPresen', $allPresen)
                ->with('indicePresen', round(($presentes * 100) / $allPresen), 2)
                ->with('fechas', $fechas);
        } catch (AuthorizationException $e) {
            return view('home')
                ->with('periodo', $periodo)
                ->with('fechaCierre', $fechaCierre)
                ->with('indicePresen', round(($presentes * 100) / $allPresen), 2)
                ->with('cantAgentes', $agentesActivo)
                ;
        }
    }
    
    
    public function grafico()
    {
        try {
            $today = new \DateTime('now');
            $start = (new \DateTime('now'))->modify('-4day');
            
            $presenByDay = Presentismo::selectRaw('count(id) as presentismo, fecha')
                ->whereDate('fecha', '>=', $start)
                ->whereDate('fecha', '<=', $today)
                ->groupBy('fecha')
                ->orderBy('fecha', 'ASC')
                ->get();
            
            $agentesActivoByDay = Param::selectRaw('valor as agentes, DATE(created_at) as fecha')
                ->where('param', '=', Param::CANT_ACTIVOS)
                ->whereDate('created_at', '>=', $start)
                ->whereDate('created_at', '<=', $today)
                ->orderBy('created_at', 'ASC')
                ->get();
            
            return [
                'presentByDay' => $presenByDay->keyBy('fecha'),
                'activosByDay' => $agentesActivoByDay->keyBy('fecha'),
            ];
        } catch (\Exception $e) {
            return [
                'presentByDay' => [],
                'activosByDay' => [],
            ];
            
        }
        
    }
    
    public function bases()
    {
        try {
            $bases = Base::with([
                'operativos' => function ($with) {
                    $with->selectRaw('id_base, count(id_agente) as agentes')
                        ->whereHas('agente', function ($whereHasAgente) {
                            $whereHasAgente->whereHas('contrato', function ($whereHasContrato) {
                                $whereHasContrato->whereIn('id_estado_contrato',
                                    EstadoContrato::getEstadosEquivalentesActivos()->pluck('id'));
                            });
                        })
                        ->groupBy('id_base');
                },
            ])
                ->get()
                ->keyBy('id');
            
            $presen = Presentismo::selectRaw('operativos.id_base as base, count(operativos.id_base) as presentismo')
                ->join('agentes', 'presentismos.id_agente', '=', 'agentes.id')
                ->join('operativos', 'operativos.id_agente', '=', 'agentes.id')
                ->whereDate('fecha', '=', (new \DateTime('now'))->format('Y-m-d'))
                ->groupBy('operativos.id_base')
                ->get()
                ->keyBy('base');
            
            foreach ($bases as $idBase => $base) {
                $base->agentes     = $base->operativos->first() ?: [
                    'id_base' => $idBase,
                    'agentes' => 0,
                ];
                $base->presentismo = $presen->get($idBase) ?: ['base' => $idBase, 'presentismo' => 0];
            }
            
            return $bases;
        } catch (\Exception $e) {
            return [];
        }
        
    }
}
