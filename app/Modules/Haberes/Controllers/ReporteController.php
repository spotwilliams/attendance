<?php

namespace Cat\Modules\Haberes\Controllers\Registro;

use Cat\Models\Base;
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
    
    
    public function reporte(Request $request)
    {
        $input = $request->all();
        try {
            $periodo = Periodo::findOrFail($input['periodo']);
            $base    = Base::findOrFail($input['base']);
            $turno   = Turno::findOrFail($input['turno']);
            
            /** @var Collection $agentes */
            $agentes = $this->helper
                ->getAgentesForHaberesReport($base, $turno, $periodo);
            
            $service = new Reporte($agentes);
            
            $service->execute();
            
        } catch (\Exception $e) {

            Flash::error('No se ha podido continuar. Intente nuevamente');
            return view('Haberes::calculo.index-base');
        }
        
    }
    
    public function reportePreliminar(Request $request)
    {
        $input = $request->all();
        try {
            $periodo = Periodo::findOrFail($input['periodo']);
            $base    = Base::findOrFail($input['base']);
            $turno   = Turno::findOrFail($input['turno']);
            
            /** @var Collection $agentes */
            $agentes = Facilitador::preliminar($base, $periodo, $turno);
            
            $service = new Reporte(new Collection($agentes));
            
            $service->execute();
            
        } catch (\Exception $e) {
            Flash::error('No se ha podido continuar. Intente nuevamente');
            return view('Haberes::calculo.index-base');
        }
        
    }
}
