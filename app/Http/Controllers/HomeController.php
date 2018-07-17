<?php

namespace Cat\Http\Controllers;

use Cat\Helpers\Calculation;
use Cat\Http\Requests;
use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\EstadoContrato;
use Cat\Models\Param;
use Cat\Models\Periodo;
use Cat\Models\Presentismo;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Cat\Repositories\PeriodoRepository;
use Cat\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Facades\Datatables;

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
        $today         = new \DateTime('now');
        $start         = (new \DateTime('now'))->modify('-4day');
        $fechaCierre   = Param::fechaCierre();
        $cantBases     = Base::count();
        $cantUsers     = User::count();
        $periodo       = $repo->getOrCreatePeriodoActivo($today);
        $fechas        = Calculation::getAllDaysBetween($start, $today);
        $agentesActivo = AgenteRepository::getCountActivos();
        
        $tipoPresen = TipoPresentismo::where('codigo', '=', TipoPresentismo::PRESENTE)->first();
        $presentes  = Presentismo::where('id_periodo', '=', $periodo->id)
            ->where('id_tipo_presentismo', '=', $tipoPresen->id)
            ->count();
        
        $allPresen = Presentismo::where('id_periodo', '=', $periodo->id)
            ->count();
        
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

        return view('home')
            ->with('cantBases', $cantBases)
            ->with('cantUsers', $cantUsers)
            ->with('cantAgentes', $agentesActivo)
            ->with('periodo', $periodo)
            ->with('fechaCierre', $fechaCierre)
            ->with('presentes', $presentes)
            ->with('allPresen', $allPresen)
            ->with('indicePresen', round(($presentes * 100) / $allPresen), 2)
            ->with('fechas', $fechas)
            ->with('presentByDay', $presenByDay->keyBy('fecha'))
            ->with('activosByDay', $agentesActivoByDay->keyBy('fecha'))
            ;
    }
}
