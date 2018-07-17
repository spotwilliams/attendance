<?php

namespace Cat\Http\Controllers;

use Cat\Http\Requests;
use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\EstadoContrato;
use Cat\Models\Param;
use Cat\Models\Periodo;
use Cat\Models\Presentismo;
use Cat\Models\TipoPresentismo;
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
        $today       = new \DateTime('2018-04-31');
        $fechaCierre = Param::fechaCierre();
        $cantBases   = Base::count();
        $cantUsers   = User::count();
        $periodo     = $repo->getOrCreatePeriodoActivo($today);
        
        $agentesActivo = Agente::whereHas('contrato', function ($where) {
            /** @var Collection $activos */
            $activos = EstadoContrato::getEstadosEquivalentesActivos();
            $where->whereIn('id_estado_contrato', $activos->pluck('id')->toArray());
            
        })->count();
        
        $tipoPresen = TipoPresentismo::where('codigo', '=', TipoPresentismo::PRESENTE)->first();
        $presentes  = Presentismo::where('id_periodo', '=', $periodo->id)
            ->where('id_tipo_presentismo', '=', $tipoPresen->id)
            ->count();
        
        $allPresen = Presentismo::where('id_periodo', '=', $periodo->id)
            ->count();
        
        
//        $agentes =
        return view('home')
            ->with('cantBases', $cantBases)
            ->with('cantUsers', $cantUsers)
            ->with('cantAgentes', $agentesActivo)
            ->with('periodo', $periodo)
            ->with('fechaCierre', $fechaCierre)
            ->with('presentes', $presentes)
            ->with('allPresen', $allPresen)
            ->with('indicePresen', round(($presentes * 100) / $allPresen), 2);
    }
}
