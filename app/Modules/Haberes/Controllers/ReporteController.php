<?php

namespace Cat\Modules\Haberes\Controllers\Registro;

use Cat\Models\Base;
use Cat\Models\EstadoPeriodo;
use Cat\Models\Periodo;
use Cat\Models\Turno;
use Cat\Modules\Haberes\Controllers\Helpers\Data;
use Cat\Modules\Haberes\Services\Helpers\Facilitador;
use Cat\Modules\Haberes\Services\Reporte\Reporte;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Laracasts\Flash\Flash;

class ReporteController extends AppBaseController
{
    
    /** @var  Data */
    private $helper;
    
    public function __construct(Data $helper)
    {
        $this->helper = $helper;
        $this->middleware('auth');
        
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function reporte(Request $request)
    {
        $this->authorize('reporte', $this);
        $input = $request->all();

        try {
            $periodo = Periodo::findOrFail($input['id_periodo']);
            $base    = Base::findOrFail($input['base']);
            $turno   = Turno::findOrFail($input['turno']);
            
            /** @var Collection $agentes */
            $agentes = $this->helper
                ->getAgentesForHaberesReport($base, $turno, $periodo);
            
            $service = new Reporte($agentes);
            
            $service->execute();
        } catch (\Exception $e) {
            Flash::error('No se ha podido generar el reporte, intente nuevamente.'. $e->getMessage());
            
            $estadoPeriodo = EstadoPeriodo::where('id_periodo', '=', $input['periodo'])
                ->where('id_base', '=', $base->id)
                ->where('id_turno', '=', $turno->id)
                ->first();
            
            return view('Haberes::calculo.error-reporte')
                ->with('estadoPeriodo', $estadoPeriodo);
        }
        
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function reportePreliminar(Request $request)
    {
        $this->authorize('reportePreliminar', $this);
        
        $input = $request->all();
        try {
            $periodo = Periodo::findOrFail($input['id_periodo']);
            $base    = Base::findOrFail($input['base']);
            $turno   = Turno::findOrFail($input['turno']);
            
            $estadoPeriodo = EstadoPeriodo::where('id_periodo', '=', $periodo->id)
                ->where('id_base', '=', $base->id)
                ->where('id_turno', '=', $turno->id)
                ->first();
            /** @var Collection $agentes */
            $agentes = Facilitador::preliminar($base, $periodo, $turno);
            
            $service = new Reporte(new Collection($agentes));
            
            $service->execute();
            
        } catch (\Exception $e) {
            Flash::error('No se ha podido generar el reporte, intente nuevamente.');
    
            $estadoPeriodo = EstadoPeriodo::where('id_periodo', '=', $periodo->id)
                ->where('id_base', '=', $base->id)
                ->where('id_turno', '=', $turno->id)
                ->first();
    
            return view('Haberes::calculo.error-reporte')
                ->with('estadoPeriodo', $estadoPeriodo);
        }
        
    }
}
